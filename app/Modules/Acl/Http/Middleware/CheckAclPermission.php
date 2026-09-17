<?php

namespace App\Modules\Acl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAclPermission
{
    /**
     * Handle an incoming request.
     *
     * Supports:
     * - Pipe-delimited (OR logic): permission:manage_users|manage_invoices
     * - Comma-delimited (AND logic): permission:create,edit
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = Auth::guard('admin')->user() ?? $request->user();

        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        // Check if user is super admin with full wildcard
        if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            return $next($request);
        }

        // Handle OR logic (pipe-separated)
        if (str_contains($permission, '|')) {
            $permissions = explode('|', $permission);
            if (method_exists($user, 'hasAnyPermission')) {
                if (!$user->hasAnyPermission($permissions)) {
                    abort(403, 'Unauthorized permission capability.');
                }
            } else {
                $has = false;
                foreach ($permissions as $p) {
                    if (isset($user->role) && $user->role->permissions->pluck('name')->contains($p)) {
                        $has = true;
                        break;
                    }
                }
                if (!$has) {
                    abort(403, 'Unauthorized permission capability.');
                }
            }

            return $next($request);
        }

        // Handle AND logic (comma-separated)
        if (str_contains($permission, ',')) {
            $permissions = explode(',', $permission);
            if (method_exists($user, 'hasAllPermissions')) {
                if (!$user->hasAllPermissions($permissions)) {
                    abort(403, 'Unauthorized permission capability.');
                }
            } else {
                foreach ($permissions as $p) {
                    if (!isset($user->role) || !$user->role->permissions->pluck('name')->contains($p)) {
                        abort(403, 'Unauthorized permission capability.');
                    }
                }
            }

            return $next($request);
        }

        // Single permission check
        if (method_exists($user, 'hasPermission')) {
            if (!$user->hasPermission($permission)) {
                abort(403, 'Unauthorized permission capability.');
            }
        } elseif (!isset($user->role) || !$user->role->permissions->pluck('name')->contains($permission)) {
            abort(403, 'Unauthorized permission capability.');
        }

        return $next($request);
    }
}
