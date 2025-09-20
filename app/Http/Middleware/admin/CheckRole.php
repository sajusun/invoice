<?php

namespace App\Http\Middleware\admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || !$admin->role || $admin->role->name!=$role) {
            abort(403, 'Unauthorized User Role.');
        }

       // dd($role);

        return $next($request);
    }
}

