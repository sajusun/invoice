<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SettingService
{
    /**
     * Get or create settings for a user.
     */
    public static function forUser(?User $user = null): Setting
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return new Setting([
                'company_name' => config('app.name', 'Invozen'),
                'default_currency' => 'USD',
                'default_tax_rate' => 0,
                'invoice_prefix' => 'INV-',
                'start_number' => 1,
            ]);
        }

        return $user->settings ?? Setting::firstOrCreate(
            ['user_id' => $user->id],
            [
                'company_name' => $user->name . ' Inc.',
                'company_email' => $user->email,
                'default_currency' => 'USD',
                'default_tax_rate' => 0,
                'invoice_prefix' => 'INV-',
                'start_number' => 1,
            ]
        );
    }

    /**
     * Get company data array for invoices and PDF.
     */
    public static function getCompanyData(?User $user = null): array
    {
        $settings = static::forUser($user);

        return [
            'name' => $settings->company_name ?? config('app.name', 'Invozen'),
            'email' => $settings->company_email ?? $user?->email ?? '',
            'phone' => $settings->company_phone ?? '',
            'address' => $settings->company_address ?? '',
            'logo' => $settings->company_logo ?? '',
            'currency' => $settings->default_currency ?? 'USD',
        ];
    }
}
