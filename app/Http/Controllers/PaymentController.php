<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function showPaymentForm($planId)
    {
        $plan = Plan::findOrFail($planId);
        return view('payment-page.payment-form', compact('plan'));
    }

    public function processPayment(Request $request)
    {
        $plan = Plan::findOrFail($request->plan_id);

        // Simulate successful payment (for now)
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'plan_id' => $plan->id,
            'payment_method' => 'manual',
            'amount' => $plan->price,
            'payment_status' => 'success',
        ]);

        // Update user plan
        $user = Auth::user();
        $user->plan_id = $plan->id;
        if ($plan->price > 0) {
            $user->expires_at = now()->addDays(365);
        } else {
            $user->expires_at = null;
        }
        $user->save();

        return redirect('/dashboard')->with('success', 'Your plan has been activated!');
    }

    public static function onSignUp($user): void
    {
        $plan = Plan::where('type', 'free')->first();

        $payment = Payment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'payment_method' => 'Auto Sign Up',
            'amount' => $plan->price,
            'payment_status' => 'success',
        ]);

        $user->plan_id = $plan->id;
        if ($plan->price > 0) {
            $user->expires_at = now()->addDays(365);
        } else {
            $user->expires_at = null;
        }
        $user->save();
    }
}
