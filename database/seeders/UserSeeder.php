<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $freePlan     = Plan::where('type', 'free')->first();
        $premiumPlan  = Plan::where('type', 'premium')->first();
        $businessPlan = Plan::where('type', 'business')->first();

        // 1. Primary Test User (Premium Plan)
        $testUser = User::updateOrCreate(
            ['email' => 'testuser@example.com'],
            [
                'name'              => 'Test User',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'plan_id'           => $premiumPlan?->id,
                'expires_at'        => now()->addYear(),
                'created_at'        => now()->subMonths(3),
            ]
        );

        Settings::updateOrCreate(
            ['user_id' => $testUser->id],
            [
                'company_name'       => 'Invozen Studio Inc.',
                'company_email'      => 'hello@invozenstudio.com',
                'company_phone'      => '+1 (555) 234-5678',
                'company_address'    => '450 Serenity Way, Suite 300, San Francisco, CA 94107',
                'default_currency'   => 'USD',
                'default_tax_rate'   => 10.00,
                'show_tax_column'    => true,
                'show_email_column'  => true,
                'invoice_prefix'     => 'INV-',
                'start_number'       => 1001,
            ]
        );

        UserDetail::updateOrCreate(
            ['user_id' => $testUser->id],
            [
                'address'      => '450 Serenity Way, Suite 300',
                'state'        => 'CA',
                'zip_code'     => '94107',
                'phone'        => '5552345678',
                'calling_code' => '+1',
                'country'      => 'United States',
            ]
        );

        // 2. Secondary Demo User (Free Plan)
        $freeUser = User::updateOrCreate(
            ['email' => 'john@example.com'],
            [
                'name'              => 'John Doe',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'plan_id'           => $freePlan?->id,
                'expires_at'        => null,
                'created_at'        => now()->subMonths(2),
            ]
        );

        Settings::updateOrCreate(
            ['user_id' => $freeUser->id],
            [
                'company_name'       => 'Doe Digital Works',
                'company_email'      => 'john@example.com',
                'company_phone'      => '+1 (555) 890-1234',
                'company_address'    => '120 Market St, New York, NY 10001',
                'default_currency'   => 'USD',
                'default_tax_rate'   => 5.00,
                'show_tax_column'    => false,
                'show_email_column'  => true,
                'invoice_prefix'     => 'INV-',
                'start_number'       => 101,
            ]
        );

        UserDetail::updateOrCreate(
            ['user_id' => $freeUser->id],
            [
                'address'      => '120 Market St',
                'state'        => 'NY',
                'zip_code'     => '10001',
                'phone'        => '5558901234',
                'calling_code' => '+1',
                'country'      => 'United States',
            ]
        );

        // 3. Business Demo User (Business Plan)
        $bizUser = User::updateOrCreate(
            ['email' => 'business@example.com'],
            [
                'name'              => 'Sarah Jenkins',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'plan_id'           => $businessPlan?->id,
                'expires_at'        => now()->addYear(),
                'created_at'        => now()->subMonths(1),
            ]
        );

        Settings::updateOrCreate(
            ['user_id' => $bizUser->id],
            [
                'company_name'       => 'Jenkins Global Solutions',
                'company_email'      => 'sarah@jenkinsglobal.com',
                'company_phone'      => '+44 20 7946 0991',
                'company_address'    => '221B Baker St, London, UK',
                'default_currency'   => 'USD',
                'default_tax_rate'   => 15.00,
                'show_tax_column'    => true,
                'show_email_column'  => true,
                'invoice_prefix'     => 'JGS-',
                'start_number'       => 5001,
            ]
        );

        UserDetail::updateOrCreate(
            ['user_id' => $bizUser->id],
            [
                'address'      => '221B Baker St',
                'state'        => 'London',
                'zip_code'     => 'NW1 6XE',
                'phone'        => '79460991',
                'calling_code' => '+44',
                'country'      => 'United Kingdom',
            ]
        );

        // 4. Additional Diverse Users for Dashboard Testing & Metrics
        $planList = [$freePlan?->id, $premiumPlan?->id, $businessPlan?->id];

        $extraUsers = [
            ['name' => 'Michael Chang', 'email' => 'michael.chang@example.com', 'verified' => true, 'created_days_ago' => 1],
            ['name' => 'Emily Watson', 'email' => 'emily.watson@example.com', 'verified' => true, 'created_days_ago' => 2],
            ['name' => 'David Miller', 'email' => 'david.miller@example.com', 'verified' => false, 'created_days_ago' => 3],
            ['name' => 'Jessica Taylor', 'email' => 'jessica.t@example.com', 'verified' => true, 'created_days_ago' => 0],
            ['name' => 'Alex Rivera', 'email' => 'alex.rivera@example.com', 'verified' => true, 'created_days_ago' => 5],
            ['name' => 'Sophia Martinez', 'email' => 'sophia.m@example.com', 'verified' => false, 'created_days_ago' => 8],
            ['name' => 'Liam Johnson', 'email' => 'liam.j@example.com', 'verified' => true, 'created_days_ago' => 12],
            ['name' => 'Olivia Brown', 'email' => 'olivia.b@example.com', 'verified' => true, 'created_days_ago' => 18],
        ];

        foreach ($extraUsers as $u) {
            $assignedPlanId = $planList[array_rand($planList)];
            $isPaid = $assignedPlanId !== $freePlan?->id;

            $createdDate = now()->subDays($u['created_days_ago']);

            $user = User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name'              => $u['name'],
                    'password'          => Hash::make('password'),
                    'email_verified_at' => $u['verified'] ? $createdDate : null,
                    'plan_id'           => $assignedPlanId,
                    'expires_at'        => $isPaid ? now()->addMonths(6) : null,
                    'created_at'        => $createdDate,
                    'updated_at'        => $createdDate,
                ]
            );

            Settings::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name'       => $u['name'] . ' Enterprises',
                    'company_email'      => $u['email'],
                    'company_phone'      => '+1 (555) ' . rand(100, 999) . '-' . rand(1000, 9999),
                    'company_address'    => rand(100, 999) . ' Innovation Blvd, Tech City',
                    'default_currency'   => 'USD',
                    'default_tax_rate'   => 10.00,
                    'show_tax_column'    => true,
                    'show_email_column'  => true,
                    'invoice_prefix'     => 'INV-',
                    'start_number'       => 1001,
                ]
            );

            UserDetail::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address'      => rand(100, 999) . ' Innovation Blvd',
                    'state'        => 'CA',
                    'zip_code'     => '90001',
                    'phone'        => (string) rand(1000000000, 9999999999),
                    'calling_code' => '+1',
                    'country'      => 'United States',
                ]
            );
        }
    }
}
