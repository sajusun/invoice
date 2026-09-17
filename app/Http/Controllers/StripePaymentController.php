<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;

class StripePaymentController extends Controller
{
    public function __construct()
    {
        $stripeSecret = config('services.stripe.secret') ?? env('STRIPE_SECRET');
        if ($stripeSecret) {
            Stripe::setApiKey($stripeSecret);
        }
    }

    /**
     * Show Checkout Review / Order Summary page
     */
    public function showCheckout(Request $request, Plan $plan)
    {
        $billingCycle = $request->query('cycle', 'monthly');
        if (!in_array($billingCycle, ['monthly', 'annual'])) {
            $billingCycle = 'monthly';
        }

        $user = Auth::user();

        // If free tier selected, activate directly
        if ($plan->type === 'free' || $plan->monthly_price == 0) {
            $user->plan_id = $plan->id;
            $user->billing_cycle = $billingCycle;
            $user->subscription_status = 'active';
            $user->expires_at = null;
            $user->current_period_starts_at = now();
            $user->current_period_ends_at = null;
            $user->save();

            return redirect()->route('dashboard')->with('success', 'You are now on the Free Starter plan!');
        }

        $price = $plan->getPriceForCycle($billingCycle);
        $monthlyEquivalent = ($billingCycle === 'annual') ? $plan->annual_monthly_equivalent : $plan->monthly_price;
        $savings = ($billingCycle === 'annual') ? $plan->annual_savings : 0;

        return view('payment-page.checkout', compact('plan', 'billingCycle', 'price', 'monthlyEquivalent', 'savings', 'user'));
    }

    /**
     * Initiate Stripe Checkout Session
     */
    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'billing_cycle' => 'required|in:monthly,annual',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $billingCycle = $request->billing_cycle;
        $user = Auth::user();

        // If free plan, activate right away
        if ($plan->type === 'free' || $plan->monthly_price == 0) {
            $user->plan_id = $plan->id;
            $user->billing_cycle = $billingCycle;
            $user->subscription_status = 'active';
            $user->expires_at = null;
            $user->current_period_starts_at = now();
            $user->current_period_ends_at = null;
            $user->save();

            return redirect()->route('dashboard')->with('success', 'Plan activated successfully.');
        }

        $stripeSecret = config('services.stripe.secret') ?? env('STRIPE_SECRET');

        // Check if Stripe is configured in environment
        if (empty($stripeSecret) || str_contains($stripeSecret, 'your_stripe_secret') || $stripeSecret === 'sk_test_placeholder') {
            // Safe Development Sandbox Activation
            $user->plan_id = $plan->id;
            $user->billing_cycle = $billingCycle;
            $user->subscription_status = 'active';
            $user->current_period_starts_at = now();
            $periodEndsAt = ($billingCycle === 'annual') ? now()->addYear() : now()->addMonth();
            $user->current_period_ends_at = $periodEndsAt;
            $user->expires_at = $periodEndsAt;
            $user->save();

            // Record test payment
            Payment::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'payment_method' => 'stripe_test_mode',
                'amount' => $plan->getPriceForCycle($billingCycle),
                'billing_cycle' => $billingCycle,
                'currency' => $plan->currency ?? 'USD',
                'payment_status' => 'success',
                'stripe_session_id' => 'test_session_' . uniqid(),
            ]);

            return redirect()->route('subscription.plans')->with('success', "Subscribed to {$plan->name} ({$billingCycle}) in test mode! Add STRIPE_SECRET in .env for live gateway.");
        }

        try {
            $amountInCents = (int) round($plan->getPriceForCycle($billingCycle) * 100);
            $cycleDescription = ($billingCycle === 'annual')
                ? "Annual billing (equivalent to \${$plan->annual_monthly_equivalent}/mo, Save \${$plan->annual_savings}/yr)"
                : "Monthly billing";

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'customer_email'       => $user->email,
                'line_items'           => [[
                    'price_data' => [
                        'currency'     => strtolower($plan->currency ?? 'usd'),
                        'product_data' => [
                            'name'        => "Invozen {$plan->name} Plan ({$billingCycle})",
                            'description' => $cycleDescription,
                        ],
                        'unit_amount'  => $amountInCents,
                    ],
                    'quantity'   => 1,
                ]],
                'mode'                 => 'payment',
                'client_reference_id'  => (string) $user->id,
                'metadata'             => [
                    'user_id'       => (string) $user->id,
                    'plan_id'       => (string) $plan->id,
                    'billing_cycle' => $billingCycle,
                    'plan_name'     => $plan->name,
                ],
                'success_url'          => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'           => route('stripe.cancel', ['plan' => $plan->id, 'cycle' => $billingCycle]),
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            Log::error('Stripe Checkout Session Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to initiate Stripe checkout: ' . $e->getMessage());
        }
    }

    /**
     * Handle return from successful Stripe checkout
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $user = Auth::user();

        if (!$sessionId) {
            return redirect()->route('dashboard')->with('success', 'Subscription activated successfully!');
        }

        try {
            $stripeSecret = config('services.stripe.secret') ?? env('STRIPE_SECRET');
            if ($stripeSecret) {
                Stripe::setApiKey($stripeSecret);
                $session = StripeSession::retrieve($sessionId);

                if ($session && $session->payment_status === 'paid') {
                    $planId = $session->metadata->plan_id ?? null;
                    $billingCycle = $session->metadata->billing_cycle ?? 'monthly';
                    $plan = $planId ? Plan::find($planId) : null;

                    if ($plan && $user) {
                        $periodEndsAt = ($billingCycle === 'annual') ? now()->addYear() : now()->addMonth();

                        $user->update([
                            'plan_id'                  => $plan->id,
                            'billing_cycle'            => $billingCycle,
                            'subscription_status'      => 'active',
                            'stripe_customer_id'       => $session->customer ?? $user->stripe_customer_id,
                            'stripe_subscription_id'   => $session->subscription ?? null,
                            'current_period_starts_at' => now(),
                            'current_period_ends_at'   => $periodEndsAt,
                            'expires_at'               => $periodEndsAt,
                        ]);

                        // Check if payment record already created
                        $existingPayment = Payment::where('stripe_session_id', $sessionId)->first();
                        if (!$existingPayment) {
                            Payment::create([
                                'user_id'                  => $user->id,
                                'plan_id'                  => $plan->id,
                                'payment_method'           => 'stripe',
                                'amount'                   => (float) ($session->amount_total / 100),
                                'billing_cycle'            => $billingCycle,
                                'currency'                 => strtoupper($session->currency ?? 'USD'),
                                'stripe_payment_intent_id' => $session->payment_intent ?? null,
                                'stripe_session_id'        => $sessionId,
                                'payment_status'           => 'success',
                            ]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Stripe Success Verification Failed: ' . $e->getMessage());
        }

        return view('payment-page.stripe-success');
    }

    /**
     * Handle return when user cancels checkout
     */
    public function cancel(Request $request)
    {
        $planId = $request->query('plan');
        $plan = $planId ? Plan::find($planId) : null;
        return view('payment-page.stripe-cancel', compact('plan'));
    }

    /**
     * Handle Stripe Webhooks asynchronously
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret') ?? env('STRIPE_WEBHOOK_SECRET');

        $event = null;

        if ($endpointSecret && $sigHeader) {
            try {
                $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
            } catch (SignatureVerificationException $e) {
                Log::warning('Stripe Webhook Signature Verification Failed: ' . $e->getMessage());
                return response()->json(['error' => 'Invalid signature'], 400);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid payload'], 400);
            }
        } else {
            $event = json_decode($payload);
        }

        if (!$event) {
            return response()->json(['status' => 'ignored'], 200);
        }

        $eventType = is_object($event) ? ($event->type ?? null) : ($event['type'] ?? null);
        $dataObject = is_object($event) ? ($event->data->object ?? null) : ($event['data']['object'] ?? null);

        switch ($eventType) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($dataObject);
                break;

            case 'invoice.payment_succeeded':
                $this->handleInvoicePaymentSucceeded($dataObject);
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($dataObject);
                break;
        }

        return response()->json(['status' => 'success'], 200);
    }

    protected function handleCheckoutSessionCompleted($session)
    {
        $userId = $session->metadata->user_id ?? $session->client_reference_id ?? null;
        $planId = $session->metadata->plan_id ?? null;
        $billingCycle = $session->metadata->billing_cycle ?? 'monthly';

        if ($userId && $planId) {
            $user = User::find($userId);
            $plan = Plan::find($planId);

            if ($user && $plan) {
                $periodEndsAt = ($billingCycle === 'annual') ? now()->addYear() : now()->addMonth();

                $user->update([
                    'plan_id'                  => $plan->id,
                    'billing_cycle'            => $billingCycle,
                    'subscription_status'      => 'active',
                    'stripe_customer_id'       => $session->customer ?? $user->stripe_customer_id,
                    'stripe_subscription_id'   => $session->subscription ?? null,
                    'current_period_starts_at' => now(),
                    'current_period_ends_at'   => $periodEndsAt,
                    'expires_at'               => $periodEndsAt,
                ]);

                Payment::firstOrCreate(
                    ['stripe_session_id' => $session->id],
                    [
                        'user_id'                  => $user->id,
                        'plan_id'                  => $plan->id,
                        'payment_method'           => 'stripe',
                        'amount'                   => (float) ($session->amount_total / 100),
                        'billing_cycle'            => $billingCycle,
                        'currency'                 => strtoupper($session->currency ?? 'USD'),
                        'stripe_payment_intent_id' => $session->payment_intent ?? null,
                        'payment_status'           => 'success',
                    ]
                );
            }
        }
    }

    protected function handleInvoicePaymentSucceeded($invoice)
    {
        $customerId = $invoice->customer ?? null;
        if ($customerId) {
            $user = User::where('stripe_customer_id', $customerId)->first();
            if ($user) {
                $cycle = $user->billing_cycle ?? 'monthly';
                $periodEndsAt = ($cycle === 'annual') ? now()->addYear() : now()->addMonth();
                $user->update([
                    'subscription_status'    => 'active',
                    'current_period_ends_at' => $periodEndsAt,
                    'expires_at'             => $periodEndsAt,
                ]);
            }
        }
    }

    protected function handleSubscriptionDeleted($subscription)
    {
        $customerId = $subscription->customer ?? null;
        if ($customerId) {
            $user = User::where('stripe_customer_id', $customerId)->first();
            if ($user) {
                $user->update([
                    'subscription_status' => 'canceled',
                    'canceled_at'         => now(),
                ]);
            }
        }
    }
}
