<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserRole;
use Illuminate\Console\Scheduling\Schedule; // Tetap import ini untuk kejelasan

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => CheckUserRole::class, 
            'active.role.check' => EnsureActiveRoleSelected::class, 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    // Perubahan ada di sini: Tambahkan backslash di depan Schedule
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) { 
        // Jalankan perintah pengingat event setiap hari pada jam 8 pagi
        // Pastikan Anda sudah membuat Artisan Command `SendEventReminders`
        // $schedule->command('reminders:send-event')->dailyAt('08:00');

        // Untuk pengujian, Anda bisa menjalankannya setiap menit:
        $schedule->command('reminders:send-event')->everyMinute();
    })
    ->create();
