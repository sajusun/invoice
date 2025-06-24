<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlanExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->expires_at && now()->greaterThan($user->expires_at)) {
            // Reset to free plan
            $user->plan_id = Plan::where('type', 'free')->first()->id;
            $user->expires_at = null;
            $user->save();

            return redirect('/choose-plan')->with('error', 'Your subscription expired. Please renew.');
        }

        return $next($request);
    }
}
