<?php

use App\Http\Middleware\ApiEmailVerified;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\EnsureAdminAuthenticated;
use App\Http\Middleware\EnsureApiAuthenticated;
use App\Http\Middleware\GuestApiSanctum;
use App\Http\Middleware\RedirectIfAdminAuthenticated;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\ShouldNotVerifyEmail;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',


        then: function () {

            // auth routes,
            Route::middleware(['web', 'redirect_if_admin_authenticated'])
                ->prefix('{locale}/dashboard')
                ->name('dashboard.auth.')
                ->group(base_path('routes/auth.php'));

            //dashboard routes
            Route::middleware(['web', 'ensure_admin_authenticated'])
                ->prefix('{locale}/dashboard')
                ->name('dashboard.')
                ->group(base_path('routes/dashboard.php'));
        },
    )

    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'redirect_if_admin_authenticated' => RedirectIfAdminAuthenticated::class,
            'ensure_admin_authenticated' => EnsureAdminAuthenticated::class,
            'ensure_api_authenticated' => EnsureApiAuthenticated::class,
            'guest_api_sanctum' => GuestApiSanctum::class,
            'should_email_verified' => ApiEmailVerified::class,
            'should_not_verify_email' => ShouldNotVerifyEmail::class
        ]);

        // this will append middleware for all routes
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
