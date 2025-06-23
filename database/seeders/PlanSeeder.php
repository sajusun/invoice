<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'name' => 'Free',
            'price' => 0,
            'type' => 'free',
            'max_invoices' => 50,
            'max_customers' => 100
        ]);

        Plan::create([
            'name' => 'Premium',
            'price' => 9.99,
            'type' => 'premium',
            'max_invoices' => null, // unlimited
            'max_customers' => null // unlimited
        ]);

    }
}
