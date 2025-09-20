<?php
namespace App\Services\Admin;

use Illuminate\Support\Facades\Auth;

class AuthNeed{
    public static function permission($permission='read'): AuthNeed
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin->role->permissions->pluck('name')->contains($permission)) {
            abort(403, 'You do not have permission.');
        }
        return new self();
    }


    public function role($role=''): AuthNeed
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || !$admin->role || !$this->hasRole($role)) {
            abort(403, 'Unauthorized User Role.');
        }
        return new self();
    }
    function hasRole($roles): bool
    {
        $admin = Auth::guard('admin')->user();
        $roles = is_string($roles) ? [$roles] : $roles;
        return in_array($admin->role->name, $roles);
    }

}
