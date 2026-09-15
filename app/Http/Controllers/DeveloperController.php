<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\WebhookEndpoint;
use App\Services\ApiKeyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DeveloperController extends Controller
{
    public function __construct(
        protected ApiKeyService $apiKeyService
    ) {}

    /**
     * Display API Keys Management Page.
     */
    public function index(): View
    {
        $user = Auth::user();
        $apiKeys = $user->apiKeys()->latest()->get();
        $webhooks = $user->webhookEndpoints()->latest()->get();

        return view('pages.developer.api_keys', compact('apiKeys', 'webhooks'));
    }

    /**
     * Create a new API Key.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'scopes' => 'nullable|array',
        ]);

        $user = Auth::user();
        $scopes = $request->input('scopes', ['*']);

        $result = $this->apiKeyService->generate($user, $request->name, $scopes);

        return redirect()->route('developer.api-keys')
            ->with('success', 'API Key generated successfully!')
            ->with('new_api_key', [
                'name'       => $result['api_key']->name,
                'public_key' => $result['api_key']->public_key,
                'secret_key' => $result['plain_secret_key'],
            ]);
    }

    /**
     * Toggle active / revoked status.
     */
    public function toggle(ApiKey $apiKey): RedirectResponse
    {
        if ($apiKey->user_id !== Auth::id()) {
            abort(403);
        }

        $apiKey->update(['is_active' => !$apiKey->is_active]);

        $status = $apiKey->is_active ? 'activated' : 'revoked';
        return back()->with('success', "API Key has been {$status}.");
    }

    /**
     * Delete an API key permanently.
     */
    public function destroy(ApiKey $apiKey): RedirectResponse
    {
        if ($apiKey->user_id !== Auth::id()) {
            abort(403);
        }

        $this->apiKeyService->delete($apiKey);

        return back()->with('success', 'API Key deleted permanently.');
    }

    /**
     * Create a new Webhook Endpoint.
     */
    public function storeWebhook(Request $request): RedirectResponse
    {
        $request->validate([
            'url'    => 'required|url|max:255',
            'events' => 'required|array|min:1',
        ]);

        $user = Auth::user();

        WebhookEndpoint::create([
            'user_id'   => $user->id,
            'url'       => $request->url,
            'secret'    => 'whsec_' . Str::random(32),
            'events'    => $request->events,
            'is_active' => true,
        ]);

        return back()->with('success', 'Webhook endpoint registered successfully.');
    }

    /**
     * Delete a webhook endpoint.
     */
    public function destroyWebhook(WebhookEndpoint $webhook): RedirectResponse
    {
        if ($webhook->user_id !== Auth::id()) {
            abort(403);
        }

        $webhook->delete();

        return back()->with('success', 'Webhook endpoint deleted.');
    }

    /**
     * Interactive Developer API Documentation.
     */
    public function docs(): View
    {
        $user = Auth::user();
        $apiKey = $user ? $user->apiKeys()->where('is_active', true)->first() : null;

        return view('pages.api-docs', compact('apiKey'));
    }
}
