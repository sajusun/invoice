<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paidPlans = Plan::where('price', '>', 0)->get();
        if ($paidPlans->isEmpty()) {
            return;
        }

        $users = User::all();
        $methods = ['Stripe', 'PayPal', 'SSLCommerz', 'TwoCheckout', 'Manually Set'];

        foreach ($users as $user) {
            // Only seed if user doesn't already have payment records
            if ($user->payments()->count() == 0 && $user->plan_id && $user->plan && $user->plan->price > 0) {
                $daysAgo = rand(10, 90);
                Payment::create([
                    'user_id'        => $user->id,
                    'plan_id'        => $user->plan_id,
                    'payment_method' => $methods[array_rand($methods)],
                    'amount'         => $user->plan->price,
                    'payment_status' => 'success',
                    'created_at'     => now()->subDays($daysAgo),
                    'updated_at'     => now()->subDays($daysAgo),
                ]);
            }
        }

        // Add additional history for primary test user if needed
        $testUser = User::where('email', 'testuser@example.com')->first();
        if ($testUser && $testUser->payments()->count() < 2 && $paidPlans->isNotEmpty()) {
            $premiumPlan = $paidPlans->first();
            Payment::create([
                'user_id'        => $testUser->id,
                'plan_id'        => $premiumPlan->id,
                'payment_method' => 'Stripe',
                'amount'         => $premiumPlan->price,
                'payment_status' => 'success',
                'created_at'     => now()->subDays(60),
                'updated_at'     => now()->subDays(60),
            ]);
            Payment::create([
                'user_id'        => $testUser->id,
                'plan_id'        => $premiumPlan->id,
                'payment_method' => 'PayPal',
                'amount'         => $premiumPlan->price,
                'payment_status' => 'success',
                'created_at'     => now()->subDays(30),
                'updated_at'     => now()->subDays(30),
            ]);
        }
    }
}
