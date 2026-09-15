<?php

namespace App\Services;

use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Support\Str;

class ApiKeyService
{
    /**
     * Generate a new Public Key and Secret Key pair for a user.
     * Returns an array containing the model and the plain-text secret key (shown only once).
     */
    public function generate(User $user, string $name, array $scopes = ['*'], ?string $expiresAt = null): array
    {
        $publicKey = 'inv_live_pk_' . Str::random(24);
        $plainSecretKey = 'inv_live_sk_' . Str::random(32);

        $secretKeyHash = hash('sha256', $plainSecretKey);
        $secretPreview = '...' . substr($plainSecretKey, -4);

        $apiKey = ApiKey::create([
            'user_id'         => $user->id,
            'name'            => $name,
            'public_key'      => $publicKey,
            'secret_key_hash' => $secretKeyHash,
            'secret_preview'  => $secretPreview,
            'scopes'          => $scopes,
            'expires_at'      => $expiresAt,
            'is_active'       => true,
        ]);

        return [
            'api_key'          => $apiKey,
            'plain_secret_key' => $plainSecretKey,
        ];
    }

    /**
     * Validate incoming Secret Key token and return the associated active ApiKey model.
     */
    public function authenticate(string $token): ?ApiKey
    {
        $token = trim($token);
        if (!str_starts_with($token, 'inv_live_sk_') && !str_starts_with($token, 'inv_test_sk_')) {
            return null;
        }

        $hash = hash('sha256', $token);

        $apiKey = ApiKey::with('user.plan')
            ->where('secret_key_hash', $hash)
            ->where('is_active', true)
            ->first();

        if (!$apiKey) {
            return null;
        }

        // Check if expired
        if ($apiKey->expires_at && $apiKey->expires_at->isPast()) {
            return null;
        }

        // Update last used timestamp
        $apiKey->updateQuietly(['last_used_at' => now()]);

        return $apiKey;
    }

    /**
     * Revoke or toggle an API key.
     */
    public function revoke(ApiKey $apiKey): bool
    {
        return $apiKey->update(['is_active' => false]);
    }

    /**
     * Delete an API key permanently.
     */
    public function delete(ApiKey $apiKey): bool
    {
        return $apiKey->delete();
    }
}
