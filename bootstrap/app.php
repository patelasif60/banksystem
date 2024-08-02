<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TwoFactor;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('twofactor',[
            TwoFactor::class,
        ]);
        $middleware->appendToGroup('isadmin',[
           IsAdmin::class,
        ]);
        $middleware->appendToGroup('isuser',[
            IsUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
