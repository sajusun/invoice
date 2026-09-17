<?php
namespace App\Services\Admin;

use Illuminate\Support\Facades\Auth;

class AuthNeed
{
    public static function permission(string $permission = 'read'): self
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || !method_exists($admin, 'hasPermission') || !$admin->hasPermission($permission)) {
            abort(403, 'You do not have permission.');
        }

        return new self();
    }

    public function role(string|array $role = ''): self
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || !method_exists($admin, 'hasRole') || !$admin->hasRole($role)) {
            abort(403, 'Unauthorized User Role.');
        }

        return new self();
    }

    public function hasRole(string|array $roles): bool
    {
        $admin = Auth::guard('admin')->user();

        return $admin && method_exists($admin, 'hasRole') && $admin->hasRole($roles);
    }
}
