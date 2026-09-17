<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Services\Admin\AuthNeed;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show the form for creating a new admin user.
     */
    public function create()
    {
        AuthNeed::permission('*')->role(['super_admin']);
        $roles = Role::with('permissions')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created admin user in storage.
     */
    public function store(Request $request)
    {
        AuthNeed::permission('*')->role(['super_admin']);

        // Validate form inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Create new admin user
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.roles.index')->with('admin', 'New administrator account created successfully.');
    }

    /**
     * Show the form for editing an admin user.
     */
    public function edit($id)
    {
        AuthNeed::permission('*')->role(['super_admin']);

        $user = Admin::with('role.permissions')->findOrFail($id);
        $roles = Role::with('permissions')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified admin user in storage.
     */
    public function update(Request $request, $id)
    {
        AuthNeed::permission('*')->role(['super_admin']);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8',
        ]);

        $user = Admin::findOrFail($id);
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.roles.index')->with('admin', 'Administrator account updated successfully.');
    }

    /**
     * Remove the specified admin user from storage.
     */
    public function delete($id): RedirectResponse
    {
        AuthNeed::permission('*')->role(['super_admin']);
        
        $currentAdmin = Auth::guard('admin')->user();
        $user = Admin::with('role')->findOrFail($id);

        if ($currentAdmin->id === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own administrator account.');
        }

        if ($user->role && $user->role->name === 'super_admin') {
            return redirect()->back()->with('error', 'Super Administrator accounts cannot be deleted.');
        }

        $user->delete();
        return redirect()->back()->with('admin', 'Administrator account deleted successfully.');
    }
}
