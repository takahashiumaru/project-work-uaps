<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// 1. PENTING: Import class Middleware yang sudah kita buat
use App\Http\Middleware\CheckStationStatus; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 2. PENTING: Daftarkan middleware ke grup 'web'
        // 'append' artinya dijalankan setelah middleware bawaan Laravel selesai
        $middleware->web(append: [
            CheckStationStatus::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();