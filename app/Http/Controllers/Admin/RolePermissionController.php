<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Modules\Acl\Services\RolePermissionService;
use App\Services\Admin\AuthNeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

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
     * Store a newly created custom role with assigned permissions.
     */
    public function storeRole(Request $request)
    {
        AuthNeed::permission('*')->role('super_admin');

        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $role = $this->aclService->createRole(
                $request->name,
                $request->input('permissions', [])
            );

            return redirect()->route('admin.roles.index')->with('role', "Role '{$role->name}' created successfully with assigned permissions.");
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update an existing custom role and its permissions.
     */
    public function updateRole(Request $request, int|string $id)
    {
        AuthNeed::permission('*')->role('super_admin');

        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $role = Role::findOrFail($id);
            $this->aclService->updateRole(
                $role,
                $request->name,
                $request->input('permissions', [])
            );

            return redirect()->route('admin.roles.index')->with('role', "Role '{$role->name}' updated successfully.");
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Safely delete a custom role.
     */
    public function destroyRole(int|string $id)
    {
        AuthNeed::permission('*')->role('super_admin');

        try {
            $role = Role::findOrFail($id);
            $roleName = $role->name;
            $this->aclService->deleteRole($role);

            return redirect()->route('admin.roles.index')->with('role', "Role '{$roleName}' deleted successfully.");
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update permissions matrix for all non-superadmin roles.
     */
    public function update(Request $request)
    {
        AuthNeed::permission('*')->role('super_admin');

        $permissions = $request->input('permissions', []);
        $this->aclService->syncPermissionMatrix($permissions);

        return redirect()->back()->with('role', 'Permissions matrix updated successfully.');
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
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }

        $this->aclService->assignRole($admin, $request->role_id);

        return redirect()->back()->with('role', 'Administrator role updated successfully.');
    }
}
