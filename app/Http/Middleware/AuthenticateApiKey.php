<?php

namespace App\Http\Middleware;

use App\Services\ApiKeyService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiKey
{
    public function __construct(
        protected ApiKeyService $apiKeyService
    ) {}

    /**
     * Handle an incoming request authenticated via Secret Key.
     */
    public function handle(Request $request, Closure $next, ...$requiredScopes): Response
    {
        $token = $request->bearerToken() ?? $request->header('X-API-KEY');

        if (!$token) {
            return response()->json([
                'success' => false,
                'error'   => 'Unauthorized',
                'message' => 'API Secret Key is missing. Provide Authorization: Bearer inv_live_sk_... header.',
            ], 401);
        }

        $apiKey = $this->apiKeyService->authenticate($token);

        if (!$apiKey || !$apiKey->user) {
            return response()->json([
                'success' => false,
                'error'   => 'Unauthorized',
                'message' => 'Invalid or expired API Secret Key.',
            ], 401);
        }

        // Scope validation
        if (!empty($requiredScopes)) {
            foreach ($requiredScopes as $scope) {
                if (!$apiKey->hasScope($scope)) {
                    return response()->json([
                        'success' => false,
                        'error'   => 'Forbidden',
                        'message' => "This API key does not have the required '{$scope}' scope.",
                    ], 403);
                }
            }
        }

        // Set the authenticated user for the request
        $request->setUserResolver(fn () => $apiKey->user);
        $request->attributes->set('api_key', $apiKey);

        return $next($request);
    }
}
