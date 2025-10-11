<?php

use App\Http\Middleware\admin\AdminAuthenticate;
use App\Http\Middleware\admin\CheckPermission;
use App\Http\Middleware\admin\CheckRole;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckPlanExpiry;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
       //
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'checkPlanExpiry' => CheckPlanExpiry::class,
            'permission' => CheckPermission::class,
            'role' => CheckRole::class,
//            'admin.auth' => AdminAuthenticate::class,
        ]);
//        $middleware->validateCsrfTokens([
//            '/ssl/success',
//            '/ssl/fail',
//        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
