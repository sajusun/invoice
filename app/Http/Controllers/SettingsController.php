<?php

namespace App\Http\Controllers;

use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function edit(): View
    {
        $user = Auth::user();
        $settings = SettingService::forUser($user);

        $currencies = [
            'USD' => ['name' => 'US Dollar', 'symbol' => '$'],
            'EUR' => ['name' => 'Euro', 'symbol' => '€'],
            'GBP' => ['name' => 'British Pound', 'symbol' => '£'],
            'BDT' => ['name' => 'Bangladeshi Taka', 'symbol' => '৳'],
            'INR' => ['name' => 'Indian Rupee', 'symbol' => '₹'],
            'CAD' => ['name' => 'Canadian Dollar', 'symbol' => 'CA$'],
            'AUD' => ['name' => 'Australian Dollar', 'symbol' => 'AU$'],
            'AED' => ['name' => 'UAE Dirham', 'symbol' => 'AED'],
            'SGD' => ['name' => 'Singapore Dollar', 'symbol' => 'SG$'],
            'JPY' => ['name' => 'Japanese Yen', 'symbol' => '¥'],
        ];

        return view('settings.edit', compact('settings', 'user', 'currencies'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name'      => 'required|string|max:255',
            'company_email'     => 'nullable|email|max:255',
            'company_phone'     => 'nullable|string|max:30',
            'company_address'   => 'nullable|string|max:500',
            'company_logo'      => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'remove_logo'       => 'nullable|boolean',
            'default_currency'  => 'required|string|max:10',
            'default_tax_rate'  => 'nullable|numeric|min:0|max:100',
            'invoice_prefix'    => 'nullable|string|max:10',
            'start_number'      => 'nullable|integer|min:1',
            'show_tax_column'   => 'nullable|boolean',
            'show_email_column' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $settings = SettingService::forUser($user);

        $data = [
            'company_name'      => $validated['company_name'],
            'company_email'     => $validated['company_email'] ?? null,
            'company_phone'     => $validated['company_phone'] ?? null,
            'company_address'   => $validated['company_address'] ?? null,
            'default_currency'  => strtoupper($validated['default_currency']),
            'default_tax_rate'  => $validated['default_tax_rate'] ?? 0,
            'invoice_prefix'    => !empty($validated['invoice_prefix']) ? rtrim($validated['invoice_prefix'], '-') . '-' : 'INV-',
            'start_number'      => $validated['start_number'] ?? 1,
            'show_tax_column'   => $request->boolean('show_tax_column'),
            'show_email_column' => $request->boolean('show_email_column'),
        ];

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            $path = $request->file('company_logo')->store('logos', 'public');
            $data['company_logo'] = '/storage/' . $path;
        } elseif ($request->boolean('remove_logo')) {
            $data['company_logo'] = null;
        }

        $settings->update($data);

        return back()->with('success', 'Business profile & invoicing preferences saved successfully!');
    }

    public function companyName(): string
    {
        return Auth::user()->settings?->company_name ?? config('app.name', 'Invozen');
    }

    public function companyEmail(): ?string
    {
        return Auth::user()->settings?->company_email;
    }

    public function companyAddress(): ?string
    {
        return Auth::user()->settings?->company_address;
    }

    public function companyPhone(): ?string
    {
        return Auth::user()->settings?->company_phone;
    }
}
