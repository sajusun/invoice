<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Modules\Acl\Http\Middleware\CheckAclPermission;
use App\Modules\Acl\Http\Middleware\CheckAclRole;
use App\Modules\Acl\Services\RolePermissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class AclModuleTest extends TestCase
{
    use RefreshDatabase;

    protected Role $superAdminRole;
    protected Role $adminRole;
    protected Role $guestRole;
    protected Permission $permCreate;
    protected Permission $permRead;
    protected Permission $permDelete;
    protected Permission $permWildcard;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles & permissions
        $this->superAdminRole = Role::create(['name' => 'super_admin']);
        $this->adminRole      = Role::create(['name' => 'admin']);
        $this->guestRole      = Role::create(['name' => 'guest']);

        $this->permCreate   = Permission::create(['name' => 'create']);
        $this->permRead     = Permission::create(['name' => 'read']);
        $this->permDelete   = Permission::create(['name' => 'delete']);
        $this->permWildcard = Permission::create(['name' => 'invoices.*']);

        $this->adminRole->permissions()->attach([
            $this->permCreate->id,
            $this->permRead->id,
            $this->permWildcard->id,
        ]);

        $this->guestRole->permissions()->attach([
            $this->permRead->id,
        ]);
    }

    public function test_model_can_assign_and_check_roles(): void
    {
        $admin = Admin::create([
            'name'     => 'Test Staff',
            'email'    => 'staff@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->assertFalse($admin->hasRole('admin'));

        $admin->assignRole('admin');
        $this->assertTrue($admin->hasRole('admin'));
        $this->assertTrue($admin->hasAnyRole(['editor', 'admin']));
        $this->assertFalse($admin->hasRole('super_admin'));
    }

    public function test_granular_permissions_and_prefix_wildcards(): void
    {
        $admin = Admin::create([
            'name'     => 'Manager',
            'email'    => 'mgr@example.com',
            'password' => bcrypt('secret123'),
            'role_id'  => $this->adminRole->id,
        ]);

        $this->assertTrue($admin->hasPermission('create'));
        $this->assertTrue($admin->hasPermission('read'));
        $this->assertFalse($admin->hasPermission('delete'));

        // Wildcard invoices.* capability
        $this->assertTrue($admin->hasPermission('invoices.create'));
        $this->assertTrue($admin->hasPermission('invoices.export'));
        $this->assertFalse($admin->hasPermission('customers.delete'));

        // Multi-permission helpers
        $this->assertTrue($admin->hasAnyPermission(['delete', 'create']));
        $this->assertFalse($admin->hasAllPermissions(['create', 'delete']));
        $this->assertTrue($admin->hasAllPermissions(['create', 'read']));
    }

    public function test_super_admin_bypasses_all_permission_checks(): void
    {
        $superAdmin = Admin::create([
            'name'     => 'Owner',
            'email'    => 'owner@example.com',
            'password' => bcrypt('secret123'),
            'role_id'  => $this->superAdminRole->id,
        ]);

        $this->assertTrue($superAdmin->isSuperAdmin());
        $this->assertTrue($superAdmin->hasPermission('any_random_nonexistent_permission'));
        $this->assertTrue($superAdmin->hasPermission('billing.erase_everything'));
    }

    public function test_request_lifecycle_permission_memoization_avoids_redundant_queries(): void
    {
        $admin = Admin::create([
            'name'     => 'Auditor',
            'email'    => 'audit@example.com',
            'password' => bcrypt('secret123'),
            'role_id'  => $this->adminRole->id,
        ]);

        // First call loads relations
        $admin->hasPermission('create');

        // Subsequent calls should hit the memoized collection with 0 DB queries
        DB::enableQueryLog();

        for ($i = 0; $i < 10; $i++) {
            $admin->hasPermission('create');
            $admin->hasPermission('read');
            $admin->hasPermission('non_existent');
        }

        $queriesCount = count(DB::getQueryLog());
        DB::disableQueryLog();

        $this->assertSame(0, $queriesCount, 'Repeated permission checks must use in-memory memoization without hitting database.');
    }

    public function test_laravel_gate_natively_integrates_with_acl_permissions(): void
    {
        $admin = Admin::create([
            'name'     => 'Operator',
            'email'    => 'op@example.com',
            'password' => bcrypt('secret123'),
            'role_id'  => $this->adminRole->id,
        ]);

        Auth::guard('admin')->setUser($admin);

        $this->assertTrue(Gate::allows('create'));
        $this->assertTrue(Gate::allows('read'));
        $this->assertFalse(Gate::allows('delete'));
    }

    public function test_acl_role_middleware_with_pipe_delimited_logic(): void
    {
        Route::get('/test-role-middleware', function () {
            return response()->json(['status' => 'granted']);
        })->middleware(CheckAclRole::class . ':super_admin|admin');

        $admin = Admin::create([
            'name'     => 'Admin User',
            'email'    => 'adm@example.com',
            'password' => bcrypt('secret123'),
            'role_id'  => $this->adminRole->id,
        ]);

        // 1. Authorized role passes
        $response = $this->actingAs($admin, 'admin')->getJson('/test-role-middleware');
        $response->assertStatus(200)->assertJson(['status' => 'granted']);

        // 2. Unauthorized role receives 403
        $guestAdmin = Admin::create([
            'name'     => 'Guest User',
            'email'    => 'gst@example.com',
            'password' => bcrypt('secret123'),
            'role_id'  => $this->guestRole->id,
        ]);

        $forbiddenResponse = $this->actingAs($guestAdmin, 'admin')->getJson('/test-role-middleware');
        $forbiddenResponse->assertStatus(403);
    }

    public function test_acl_permission_middleware_with_pipe_or_logic(): void
    {
        Route::get('/test-perm-middleware', function () {
            return response()->json(['status' => 'granted']);
        })->middleware(CheckAclPermission::class . ':delete|create');

        $admin = Admin::create([
            'name'     => 'Creator',
            'email'    => 'creator@example.com',
            'password' => bcrypt('secret123'),
            'role_id'  => $this->adminRole->id, // Has 'create', but not 'delete'
        ]);

        // OR logic passes because admin has 'create'
        $response = $this->actingAs($admin, 'admin')->getJson('/test-perm-middleware');
        $response->assertStatus(200)->assertJson(['status' => 'granted']);

        // Guest only has 'read' -> 403
        $guestAdmin = Admin::create([
            'name'     => 'Reader',
            'email'    => 'reader@example.com',
            'password' => bcrypt('secret123'),
            'role_id'  => $this->guestRole->id,
        ]);

        $forbiddenResponse = $this->actingAs($guestAdmin, 'admin')->getJson('/test-perm-middleware');
        $forbiddenResponse->assertStatus(403);
    }

    public function test_acl_trait_is_reusable_on_user_model(): void
    {
        $user = User::factory()->create([
            'role_id' => $this->adminRole->id,
        ]);

        $this->assertTrue($user->hasRole('admin'));
        $this->assertTrue($user->hasPermission('create'));
        $this->assertFalse($user->hasPermission('delete'));

        $user->revokeRole();
        $this->assertNull($user->fresh()->role_id);
        $this->assertFalse($user->hasRole('admin'));
    }

    public function test_service_can_sync_permission_matrix(): void
    {
        /** @var RolePermissionService $service */
        $service = app(RolePermissionService::class);

        // Remove 'read' and keep only 'create' for guest role
        $matrix = [
            $this->guestRole->id => [$this->permCreate->id],
        ];

        $service->syncPermissionMatrix($matrix);

        $this->guestRole->refresh();
        $this->assertTrue($this->guestRole->permissions->contains('id', $this->permCreate->id));
        $this->assertFalse($this->guestRole->permissions->contains('id', $this->permRead->id));
    }
}
