<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Modules\Acl\Services\RolePermissionService;
use App\Services\Admin\AuthNeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolePermissionController extends Controller
{
    public function __construct(
        protected RolePermissionService $aclService
    ) {}

    public function index()
    {
        $roles = $this->aclService->getAllRolesWithPermissions();
        $permissions = $this->aclService->getAllPermissions();
        $adminUsers = Admin::with('role')->get();

        return view('admin.roles.index', compact('roles', 'permissions', 'adminUsers'));
    }

    /**
     * Update permissions matrix for all non-superadmin roles.
     */
    public function update(Request $request)
    {
        AuthNeed::permission('*')->role('super_admin');

        $permissions = $request->input('permissions', []);
        $this->aclService->syncPermissionMatrix($permissions);

        return redirect()->back()->with('role', 'Permissions updated successfully.');
    }

    /**
     * Change assigned role for an administrator.
     */
    public function changeRole(Request $request, int|string $id)
    {
        AuthNeed::permission('*')->role(['super_admin']);

        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $admin = Admin::findOrFail($id);

        if ($admin->id === Auth::guard('admin')->id()) {
            return redirect()->back()->with('role', 'You cannot change your own role.');
        }

        $this->aclService->assignRole($admin, $request->role_id);

        return redirect()->back()->with('role', 'Role updated successfully.');
    }
}
