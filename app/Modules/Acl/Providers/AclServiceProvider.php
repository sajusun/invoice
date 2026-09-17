<?php

namespace App\Modules\Acl\Providers;

use App\Modules\Acl\Http\Middleware\CheckAclPermission;
use App\Modules\Acl\Http\Middleware\CheckAclRole;
use App\Modules\Acl\Services\RolePermissionService;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(RolePermissionService::class, function () {
            return new RolePermissionService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(Router $router): void
    {
        $this->registerGateHooks();
        $this->registerBladeDirectives();
        $this->registerMiddlewareAliases($router);
    }

    /**
     * Integrate with Laravel Gate for native @can and $user->can() support.
     */
    protected function registerGateHooks(): void
    {
        Auth::resolveUsersUsing(function (?string $guard = null) {
            if ($guard !== null) {
                return Auth::guard($guard)->user();
            }
            return Auth::guard('admin')->user() ?? Auth::guard('web')->user();
        });

        Gate::before(function ($user, string $ability) {
            $authUser = $user ?? Auth::guard('admin')->user() ?? Auth::user();

            if ($authUser && method_exists($authUser, 'isSuperAdmin') && $authUser->isSuperAdmin()) {
                return true;
            }

            if ($authUser && method_exists($authUser, 'hasPermission')) {
                return $authUser->hasPermission($ability) ? true : null;
            }

            return null;
        });
    }

    /**
     * Register custom Blade directives for clean view authorization.
     */
    protected function registerBladeDirectives(): void
    {
        $getCurrentAuth = function () {
            return Auth::guard('admin')->user() ?? Auth::user();
        };

        // @role('admin') or @role(['admin', 'editor'])
        Blade::if('role', function ($role) use ($getCurrentAuth) {
            $user = $getCurrentAuth();
            if (!$user) {
                return false;
            }
            return method_exists($user, 'hasRole') ? $user->hasRole($role) : false;
        });

        // @hasRole('admin')
        Blade::if('hasRole', function ($role) use ($getCurrentAuth) {
            $user = $getCurrentAuth();
            if (!$user) {
                return false;
            }
            return method_exists($user, 'hasRole') ? $user->hasRole($role) : false;
        });

        // @anyRole(['admin', 'moderator'])
        Blade::if('anyRole', function (array $roles) use ($getCurrentAuth) {
            $user = $getCurrentAuth();
            if (!$user) {
                return false;
            }
            return method_exists($user, 'hasAnyRole') ? $user->hasAnyRole($roles) : false;
        });

        // @permission('manage_invoices')
        Blade::if('permission', function ($permission) use ($getCurrentAuth) {
            $user = $getCurrentAuth();
            if (!$user) {
                return false;
            }
            return method_exists($user, 'hasPermission') ? $user->hasPermission($permission) : false;
        });

        // @hasPermission('manage_invoices')
        Blade::if('hasPermission', function ($permission) use ($getCurrentAuth) {
            $user = $getCurrentAuth();
            if (!$user) {
                return false;
            }
            return method_exists($user, 'hasPermission') ? $user->hasPermission($permission) : false;
        });

        // @superadmin
        Blade::if('superadmin', function () use ($getCurrentAuth) {
            $user = $getCurrentAuth();
            if (!$user) {
                return false;
            }
            return method_exists($user, 'isSuperAdmin') ? $user->isSuperAdmin() : false;
        });
    }

    /**
     * Register route middleware aliases.
     */
    protected function registerMiddlewareAliases(Router $router): void
    {
        $router->aliasMiddleware('acl.role', CheckAclRole::class);
        $router->aliasMiddleware('acl.permission', CheckAclPermission::class);
        $router->aliasMiddleware('role', CheckAclRole::class);
        $router->aliasMiddleware('permission', CheckAclPermission::class);
    }
}
