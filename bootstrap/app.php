<?php

use Illuminate\Foundation\Application;
use Shetabit\Visitor\Middlewares\LogVisits;
use Illuminate\Foundation\Configuration\Exceptions;
// 👇 1. Tambahkan baris ini di paling atas
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 👇 2. Tambahkan blok ini agar pencatat aktif di semua halaman web
        $middleware->web(append: [
            LogVisits::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();