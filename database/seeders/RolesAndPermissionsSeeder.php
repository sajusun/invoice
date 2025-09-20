<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = ['*', 'create', 'read', 'edit', 'delete'];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $moderator = Role::firstOrCreate(['name' => 'moderator']);
        $guest = Role::firstOrCreate(['name' => 'guest']);

        Admin::firstOrCreate(
            ['email' => 'admin123@gmail.com'],
            [
                'name' => 'default admin',
                'password' => Hash::make('admin123'),
                'role_id' => $admin->id,
            ]
        );
        Admin::firstOrCreate(
            ['email' => 'superadmin123@gmail.com'],
            [
                'name' => 'default super admin',
                'password' => Hash::make('admin123'),
                'role_id' => $superAdmin->id,
            ]
        );
        Admin::firstOrCreate(
            ['email' => 'moderator123@gmail.com'],
            [
                'name' => 'default moderator',
                'password' => Hash::make('admin123'),
                'role_id' => $moderator->id,
            ]
        );

        $superAdmin->permissions()->attach(Permission::all());
        $admin->permissions()->attach(Permission::whereIn('name', ['create', 'read', 'edit', 'delete'])->get());
        $moderator->permissions()->attach(Permission::where('name', ['create', 'read', 'edit'])->get());
        $guest->permissions()->attach(Permission::where('name', 'read')->first());

    }

}
