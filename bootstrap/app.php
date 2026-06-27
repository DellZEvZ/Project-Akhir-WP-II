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
    ->withMiddleware(function (Middleware $middleware): void {
        // Register permission middleware alias
        $middleware->alias([
            'permission'  => \App\Http\Middleware\CheckPermission::class,
            'is.customer' => \App\Http\Middleware\IsCustomer::class,
        ]);

        // Kunci akun barber agar hanya bisa mengakses halaman absensi sendiri.
        // Dipasang di grup 'web' (bukan stack global) agar berjalan SETELAH
        // session & auth state ter-resolve, supaya Auth::user() sudah terisi.
        $middleware->web(append: [
            \App\Http\Middleware\RedirectBarberToAttendance::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
