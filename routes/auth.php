<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Auth\AdminAuthController;
use App\Http\Middleware\RedirectIfAuthenticated;

// login route
Route::controller(AdminAuthController::class)->group(function(){
    Route::get('/login', 'showLoginForm')->name('showLoginForm');
    Route::post('/login', 'login')->name('login');
});


