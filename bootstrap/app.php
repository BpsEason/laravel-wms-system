<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\ApplicationBuilder;
use Illuminate\Support\Facades\Gate;

return Application::configure(basePath: __DIR__.'/..')
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders() // Default providers setup
    ->withCommands()   // Default commands setup
    ->withSchedule()   // Default scheduler setup
    ->withEventDiscoveries() // Enable event auto-discovery (optional, but good for larger projects)
    ->withPolicies(fn () => [ # New: Policy discovery
        // Map your models to policies here or use auto-discovery
        // \App\Models\Product::class => \App\Policies\ProductPolicy::class,
        // \App\Models\Warehouse::class => \App\Policies\WarehousePolicy::class,
        // ... and so on for other models
    ])->create();
