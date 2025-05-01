<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;


class SettingsController extends Controller
{
    public function edit():View
    {
        $settings = Auth::user()->settings;
        return view('settings.edit', ['settings' => $settings]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'nullable|email',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:500',
            'default_currency' => 'required|string|max:10',
            'default_tax_rate' => 'nullable|numeric|min:0',
            'invoice_prefix' => 'nullable|string|max:10',
            'start_number' => 'nullable|integer|min:0',
            'show_tax_column' => 'boolean',
            'show_email_column' => 'boolean'
        ]);
//        dd($request->all());

        $user = Auth::user();
        $user->settings()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return back()->with('success', 'Settings updated successfully!');
    }
}


