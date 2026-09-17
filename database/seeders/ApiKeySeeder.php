<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use App\Models\User;
use App\Models\WebhookEndpoint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testUser = User::where('email', 'testuser@example.com')->first();
        if (!$testUser) {
            return;
        }

        // 1. Seed Demo API Key
        ApiKey::updateOrCreate(
            ['user_id' => $testUser->id, 'name' => 'Default Production Key'],
            [
                'public_key'      => 'inv_live_pk_9a8b7c6d5e4f3a2b1c',
                'secret_key_hash' => hash('sha256', 'inv_live_sk_test_demo_key_secret_12345'),
                'secret_preview'  => '...12345',
                'scopes'          => ['*'],
                'is_active'       => true,
                'last_used_at'    => now()->subHours(2),
                'created_at'      => now()->subMonths(1),
            ]
        );

        // 2. Seed Demo Webhook Endpoint
        WebhookEndpoint::updateOrCreate(
            ['user_id' => $testUser->id, 'url' => 'https://webhook.site/invozen-demo-listener'],
            [
                'secret'     => 'whsec_' . Str::random(32),
                'events'     => ['invoice.created', 'invoice.paid', 'invoice.overdue'],
                'is_active'  => true,
                'created_at' => now()->subWeeks(2),
            ]
        );
    }
}
