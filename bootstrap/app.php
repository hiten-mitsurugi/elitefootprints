<?php

use Illuminate\Foundation\Application;

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Append additional middlewares to the 'web' group
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
        
        // Register middleware aliases dynamically here
        $middleware->alias([
            'role' => RoleMiddleware::class, // Register RoleMiddleware with alias 'role'
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Exception handling can be configured here
    })
    ->create();
