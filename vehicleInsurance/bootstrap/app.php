<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
       
         
            
            
        ]);
        $middleware->alias([
            'is_super_admin' => \App\Http\Middleware\IsSuperAdmin::class,
            'is_company_admin' => \App\Http\Middleware\IsCompanyAdminMiddleware::class,
            'is_office_admin' => \App\Http\Middleware\IsOfficeAdminMiddleware::class,
            'is_verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'maintenance' => \App\Http\Middleware\MaintenanceMiddleware::class,
        ]) ; 


        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
    // 'superadmin' => App\Http\Middleware\IsSuperAdmin::class, 


    