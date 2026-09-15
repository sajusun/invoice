<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeApiController extends Controller
{
    /**
     * Get authenticated developer user profile & limits.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load(['plan', 'settings']);

        return response()->json([
            'success' => true,
            'data'    => new UserResource($user),
        ]);
    }
}
