<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // 🔐 Middleware alias para roles de admin
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'nocache'  => \App\Http\Middleware\NoCacheMiddleware::class,
            'alumno'  => \App\Http\Middleware\AlumnoMiddleware::class,
            'director' => \App\Http\Middleware\DirectorMiddleware::class,
            'subdirector' => \App\Http\Middleware\SubdirectorMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();