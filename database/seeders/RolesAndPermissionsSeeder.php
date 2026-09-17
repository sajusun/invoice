<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Define standard permissions
        $permissions = [
            '*',
            'create',
            'read',
            'edit',
            'delete',
            'manage_users',
            'manage_roles',
            'manage_invoices',
            'manage_customers',
            'manage_payments',
            'manage_settings',
            'manage_plans',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // 2. Define roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole      = Role::firstOrCreate(['name' => 'admin']);
        $moderatorRole  = Role::firstOrCreate(['name' => 'moderator']);
        $guestRole      = Role::firstOrCreate(['name' => 'guest']);

        // 3. Assign permissions to roles
        $superAdminRole->permissions()->sync(Permission::all()->pluck('id'));
        
        $adminPermissions = Permission::whereIn('name', ['create', 'read', 'edit', 'delete', 'manage_users', 'manage_invoices', 'manage_settings'])->pluck('id');
        $adminRole->permissions()->sync($adminPermissions);

        $moderatorPermissions = Permission::whereIn('name', ['create', 'read', 'edit', 'manage_invoices'])->pluck('id');
        $moderatorRole->permissions()->sync($moderatorPermissions);

        $guestPermissions = Permission::where('name', 'read')->pluck('id');
        $guestRole->permissions()->sync($guestPermissions);

        // 4. Create default admin users
        $admins = [
            [
                'name'     => 'Super Admin',
                'email'    => 'superadmin@gmail.com',
                'password' => Hash::make('password'),
                'role_id'  => $superAdminRole->id,
                'phone'    => '+1 (555) 001-0001',
            ],
            [
                'name'     => 'System Admin',
                'email'    => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role_id'  => $adminRole->id,
                'phone'    => '+1 (555) 002-0002',
            ],
            [
                'name'     => 'Content Moderator',
                'email'    => 'moderator@gmail.com',
                'password' => Hash::make('password'),
                'role_id'  => $moderatorRole->id,
                'phone'    => '+1 (555) 003-0003',
            ],
        ];

        foreach ($admins as $adminData) {
            $phone = $adminData['phone'];
            unset($adminData['phone']);

            $admin = Admin::updateOrCreate(
                ['email' => $adminData['email']],
                $adminData
            );

            // Sync admin details
            DB::table('admins_details')->updateOrInsert(
                ['admin_id' => $admin->id],
                [
                    'phone'      => $phone,
                    'dp'         => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
