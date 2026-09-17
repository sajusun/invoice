<?php

namespace App\Modules\Acl\Traits;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * Trait HasRolesAndPermissions
 *
 * Provides plug-and-play Access Control List (ACL) capabilities to any Eloquent model
 * (e.g. Admin, User, Employee) with request-lifecycle memoization and wildcard permission support.
 */
trait HasRolesAndPermissions
{
    /**
     * In-memory memoized permission names for $O(1)$ repeated evaluation.
     *
     * @var \Illuminate\Support\Collection<string>|null
     */
    protected ?Collection $memoizedPermissions = null;

    /**
     * Relationship to the Role model.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Check if the model possesses the specified role(s).
     *
     * @param string|array<string|int>|int $roles
     */
    public function hasRole(string|array|int $roles): bool
    {
        if (!$this->role) {
            return false;
        }

        $roles = is_array($roles) ? $roles : [$roles];

        foreach ($roles as $role) {
            if (is_numeric($role) && (int) $this->role->id === (int) $role) {
                return true;
            }

            if (is_string($role) && strtolower((string) $this->role->name) === strtolower(trim($role))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the model possesses ANY of the specified roles.
     *
     * @param array<string|int> $roles
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->hasRole($roles);
    }

    /**
     * Check if the model is an unrestricted Super Admin.
     */
    public function isSuperAdmin(): bool
    {
        if ($this->hasRole('super_admin')) {
            return true;
        }

        return $this->allPermissions()->contains('*');
    }

    /**
     * Check if the model possesses a specific capability/permission.
     *
     * Automatically handles super_admin bypass and prefix wildcards (e.g. 'invoices.*').
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $target = trim(strtolower($permission));
        $permissions = $this->allPermissions();

        if ($permissions->contains($target)) {
            return true;
        }

        // Check for domain wildcards, e.g. user has 'invoices.*' and checks 'invoices.create'
        foreach ($permissions as $assigned) {
            if (str_ends_with($assigned, '.*')) {
                $prefix = substr($assigned, 0, -2);
                if (str_starts_with($target, $prefix . '.')) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if the model has ANY of the specified permissions (OR logic).
     *
     * @param array<string> $permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the model has ALL of the specified permissions (AND logic).
     *
     * @param array<string> $permissions
     */
    public function hasAllPermissions(array $permissions): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Retrieve all permissions for the model with request-level memoization.
     *
     * @return \Illuminate\Support\Collection<string>
     */
    public function allPermissions(): Collection
    {
        if ($this->memoizedPermissions !== null) {
            return $this->memoizedPermissions;
        }

        if (!$this->relationLoaded('role')) {
            $this->load('role.permissions');
        } elseif ($this->role && !$this->role->relationLoaded('permissions')) {
            $this->role->load('permissions');
        }

        $this->memoizedPermissions = $this->role?->permissions
            ? $this->role->permissions->pluck('name')->map(fn($p) => strtolower(trim((string) $p)))
            : collect();

        return $this->memoizedPermissions;
    }

    /**
     * Flush in-memory permission memoization (useful after role re-assignment).
     */
    public function flushPermissions(): static
    {
        $this->memoizedPermissions = null;
        return $this;
    }

    /**
     * Assign a role to the model.
     */
    public function assignRole(Role|string|int $role): static
    {
        if ($role instanceof Role) {
            $this->role_id = $role->id;
        } elseif (is_numeric($role)) {
            $this->role_id = (int) $role;
        } else {
            $found = Role::where('name', $role)->first();
            if ($found) {
                $this->role_id = $found->id;
            }
        }

        $this->save();
        $this->flushPermissions();
        $this->unsetRelation('role');

        return $this;
    }

    /**
     * Revoke the current role from the model.
     */
    public function revokeRole(): static
    {
        $this->role_id = null;
        $this->save();
        $this->flushPermissions();
        $this->unsetRelation('role');

        return $this;
    }
}
