<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'price' => 0.00,
                'type' => 'free',
                'max_invoices' => 50,
                'max_customers' => 100,
            ],
            [
                'name' => 'Premium',
                'price' => 9.99,
                'type' => 'premium',
                'max_invoices' => 5000,
                'max_customers' => 1000,
            ],
            [
                'name' => 'Business',
                'price' => 37.99,
                'type' => 'business',
                'max_invoices' => null,
                'max_customers' => null,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['type' => $plan['type']],
                $plan
            );
        }
    }
}
