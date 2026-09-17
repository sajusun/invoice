<?php

namespace App\Modules\Acl\Services;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RolePermissionService
{
    /**
     * Retrieve all roles with their associated permissions eagerly loaded.
     *
     * @return Collection<int, Role>
     */
    public function getAllRolesWithPermissions(): Collection
    {
        return Role::with('permissions')->orderBy('id')->get();
    }

    /**
     * Retrieve all permissions in the system.
     *
     * @return Collection<int, Permission>
     */
    public function getAllPermissions(): Collection
    {
        return Permission::orderBy('name')->get();
    }

    /**
     * Synchronize permissions for a specific role.
     *
     * @param Role|int $role
     * @param array<int> $permissionIds
     * @return Role
     */
    public function syncRolePermissions(Role|int $role, array $permissionIds): Role
    {
        $roleModel = $role instanceof Role ? $role : Role::findOrFail($role);

        // Protect super_admin from accidental privilege removal
        if ($roleModel->name === 'super_admin') {
            $allPermissionIds = Permission::pluck('id')->toArray();
            $roleModel->permissions()->sync($allPermissionIds);
            return $roleModel;
        }

        $roleModel->permissions()->sync($permissionIds);
        return $roleModel;
    }

    /**
     * Bulk update permission matrices for multiple roles.
     *
     * @param array<int, array<int>> $matrix [role_id => [permission_id_1, permission_id_2]]
     */
    public function syncPermissionMatrix(array $matrix): void
    {
        DB::transaction(function () use ($matrix) {
            foreach ($matrix as $roleId => $permissionIds) {
                $role = Role::find($roleId);
                if ($role && $role->name !== 'super_admin') {
                    $role->permissions()->sync((array) $permissionIds);
                }
            }
        });
    }

    /**
     * Assign a role to a model (Admin or User).
     */
    public function assignRole(mixed $userOrAdmin, Role|string|int $role): bool
    {
        if (method_exists($userOrAdmin, 'assignRole')) {
            $userOrAdmin->assignRole($role);
            return true;
        }

        $roleId = $role instanceof Role ? $role->id : (is_numeric($role) ? (int) $role : Role::where('name', $role)->value('id'));
        if ($roleId) {
            $userOrAdmin->role_id = $roleId;
            return $userOrAdmin->save();
        }

        return false;
    }

    /**
     * Create a new role with optional initial permissions.
     */
    public function createRole(string $name, array $permissionIds = []): Role
    {
        $role = Role::firstOrCreate(['name' => strtolower(trim($name))]);
        if (!empty($permissionIds)) {
            $role->permissions()->sync($permissionIds);
        }
        return $role;
    }

    /**
     * Create a new permission definition.
     */
    public function createPermission(string $name): Permission
    {
        return Permission::firstOrCreate(['name' => strtolower(trim($name))]);
    }
}
