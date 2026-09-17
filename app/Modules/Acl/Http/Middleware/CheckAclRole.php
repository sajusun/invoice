<?php

namespace App\Modules\Acl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAclRole
{
    /**
     * Handle an incoming request.
     *
     * Supports pipe-delimited roles: role:super_admin|admin|editor
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Identify the active authenticatable model across guards
        $user = Auth::guard('admin')->user() ?? $request->user();

        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        $roles = explode('|', $role);

        if (method_exists($user, 'hasAnyRole')) {
            if (!$user->hasAnyRole($roles)) {
                abort(403, 'Unauthorized user role.');
            }
        } elseif (!isset($user->role) || !in_array($user->role->name ?? '', $roles, true)) {
            abort(403, 'Unauthorized user role.');
        }

        return $next($request);
    }
}
