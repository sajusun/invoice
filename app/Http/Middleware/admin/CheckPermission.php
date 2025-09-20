<?php

namespace App\Http\Middleware\admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || !$admin->role || !$admin->role->permissions->pluck('name')->contains($permission)) {
            abort(403, 'Unauthorized permission.');
        }

        return $next($request);
    }
}

