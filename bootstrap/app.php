<?php

use App\Http\Middleware\EmployeeAuthMiddleware;
use App\Http\Middleware\PrevenDirectLogoutMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(callback: function (Middleware $middleware): void {
        $middleware->alias([
            'employee.direct.login' => EmployeeAuthMiddleware::class,
            'employee.direct.logout' => PrevenDirectLogoutMiddleware::class
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
