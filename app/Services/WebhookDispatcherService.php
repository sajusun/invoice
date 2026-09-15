<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class WebhookDispatcherService
{
    /**
     * Dispatch webhook event to all subscribed endpoints of a user.
     */
    public function dispatch(User $user, string $event, array $data): void
    {
        $endpoints = $user->webhookEndpoints()
            ->where('is_active', true)
            ->get();

        if ($endpoints->isEmpty()) {
            return;
        }

        $timestamp = time();
        $payload = [
            'event'     => $event,
            'timestamp' => $timestamp,
            'data'      => $data,
        ];

        $jsonPayload = json_encode($payload);

        foreach ($endpoints as $endpoint) {
            // Check if subscribed to this event or all events
            if (!empty($endpoint->events) && !in_array('*', $endpoint->events) && !in_array($event, $endpoint->events)) {
                continue;
            }

            $signature = hash_hmac('sha256', "{$timestamp}.{$jsonPayload}", $endpoint->secret);

            try {
                // Non-blocking timeout
                Http::timeout(3)
                    ->withHeaders([
                        'Content-Type'        => 'application/json',
                        'User-Agent'          => 'Invozen-Webhook/1.0',
                        'X-Invozen-Event'     => $event,
                        'X-Invozen-Signature' => $signature,
                        'X-Invozen-Timestamp' => (string) $timestamp,
                    ])
                    ->post($endpoint->url, $payload);
            } catch (Throwable $e) {
                Log::warning("Webhook delivery failed for URL {$endpoint->url}: " . $e->getMessage());
            }
        }
    }
}
