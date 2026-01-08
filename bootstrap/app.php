<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('auth',  \App\Http\Middleware\Authenticate::class);
        $middleware->appendToGroup('UserAccessWorker',  \App\Http\Middleware\UserAccessWorker::class);
        $middleware->appendToGroup('UserAccessSuperAdmin',  \App\Http\Middleware\UserAccessSuperAdmin::class);
        $middleware->appendToGroup('UserAccessHR',  \App\Http\Middleware\UserAccessHR::class);
        $middleware->appendToGroup('UserAccessShopOwner',  \App\Http\Middleware\UserAccessShopOwner::class);
        $middleware->appendToGroup('UserAccessFinancialManager',  \App\Http\Middleware\UserAccessFinancialManager::class);
        $middleware->appendToGroup('UserAccessCustomer',  \App\Http\Middleware\UserAccessCustomer::class);
        $middleware->appendToGroup('Lic',  \App\Http\Middleware\Lic::class);
        $middleware->appendToGroup('UserAccessAdmin',  \App\Http\Middleware\UserAccessAdmin::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        Integration::handles($exceptions);
    })->create();
