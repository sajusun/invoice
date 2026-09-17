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
                'name'                    => 'Starter',
                'slug'                    => 'starter',
                'type'                    => 'free',
                'price'                   => 0.00,
                'monthly_price'           => 0.00,
                'annual_price'            => 0.00,
                'annual_discount_percent' => 0,
                'currency'                => 'USD',
                'description'             => 'Essential tools for solo freelancers and individuals getting started.',
                'max_invoices'            => 10,
                'max_customers'           => 10,
                'has_api_access'          => false,
                'has_custom_branding'     => false,
                'has_recurring_invoices'  => false,
                'has_priority_support'    => false,
                'is_popular'              => false,
                'is_active'               => true,
                'features'                => [
                    'Up to 10 Invoices / month',
                    'Up to 10 Client Directory profiles',
                    'Standard PDF invoice generation',
                    'Direct customer email delivery',
                    'Multi-currency payment calculation',
                    'Invozen watermark on PDF exports',
                    'Community & email support',
                ],
            ],
            [
                'name'                    => 'Professional',
                'slug'                    => 'pro',
                'type'                    => 'premium',
                'price'                   => 15.00,
                'monthly_price'           => 15.00,
                'annual_price'            => 144.00, // $12/mo ($36 savings / 20% OFF)
                'annual_discount_percent' => 20,
                'currency'                => 'USD',
                'description'             => 'Complete power for growing businesses, agencies & scaling creators.',
                'max_invoices'            => 500,
                'max_customers'           => 500,
                'has_api_access'          => true,
                'has_custom_branding'     => true,
                'has_recurring_invoices'  => true,
                'has_priority_support'    => false,
                'is_popular'              => true,
                'is_active'               => true,
                'features'                => [
                    'Up to 500 Invoices / month',
                    'Up to 500 Client Directory profiles',
                    'Custom business logo & brand accent color',
                    'Automated Recurring Invoices & Reminders',
                    'RESTful Developer API & Webhook Dispatch',
                    'Download high-resolution PDF invoices',
                    'Remove Invozen watermark',
                    'Priority Email Support (under 12 hrs)',
                ],
            ],
            [
                'name'                    => 'Business',
                'slug'                    => 'business',
                'type'                    => 'business',
                'price'                   => 49.00,
                'monthly_price'           => 49.00,
                'annual_price'            => 468.00, // $39/mo ($120 savings / 20% OFF)
                'annual_discount_percent' => 20,
                'currency'                => 'USD',
                'description'             => 'Enterprise-grade speed, infinite quotas & dedicated compliance features.',
                'max_invoices'            => null, // Unlimited
                'max_customers'           => null, // Unlimited
                'has_api_access'          => true,
                'has_custom_branding'     => true,
                'has_recurring_invoices'  => true,
                'has_priority_support'    => true,
                'is_popular'              => false,
                'is_active'               => true,
                'features'                => [
                    'Unlimited Invoices & Receipts',
                    'Unlimited Client Directory storage',
                    'Complete White-labeling & Custom Domain',
                    'Automated Recurring Invoices & Auto-dispatch',
                    'Unlimited REST API Keys & HMAC Webhooks',
                    'Advanced Financial Analytics & Revenue Export',
                    'Multi-seat Team Collaboration',
                    '24/7 Dedicated Account Manager & SLA',
                ],
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
