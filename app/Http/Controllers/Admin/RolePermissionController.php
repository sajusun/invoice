<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Admin\AuthNeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolePermissionController extends Controller
{
    public function index()
    {
//        AuthNeed::permission('*');
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $adminUsers = Admin::all();
        return view('admin.roles.index', compact('roles', 'permissions', 'adminUsers'));
    }

//permissions update method
    public function update(Request $request, Role $role)
    {
        AuthNeed::permission('*')->role('super_admin');
        $permissions = $request->input('permissions', []);
        foreach ($permissions as $roleId => $permissionIds) {
            $role = Role::find($roleId);
            if ($role) {
                if ($role->name != 'super_admin') {
                    $role->permissions()->sync($permissionIds);
                }
            }
        }

        return redirect()->back()->with('role', 'Permissions updated successfully.');
    }

    public function changeRole(Request $request, $id)
    {
        AuthNeed::permission('*')->role(['super_admin']);

        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = Admin::findOrFail($id);

        if ($user->id == Auth::guard('admin')->id()) {
            return redirect()->back()->with('role', 'You can\'t update yourself.');
        }
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->back()->with('role', 'Role updated successfully.');
    }

}
