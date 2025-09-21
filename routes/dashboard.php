<?php

use App\Http\Controllers\Dashboard\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;

// dashboard routes
Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('welcome');
});

// profile routes
Route::controller(ProfileController::class)->prefix('profile/')->name('profile.')->group(function () {
    Route::get('/edit', 'edit')->name('edit');
    Route::put('/', 'update')->name('update');
    Route::put('/password', 'updatePassword')->name('updatePassword');
});

// users routes
Route::controller(UserController::class)->prefix('user/')->name('user.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{user}', 'show')->name('show');
    Route::get('/{user}/edit', 'edit')->name('edit');
    Route::put('/{user}', 'update')->name('update');
    Route::delete('/{user}', 'destroy')->name('destroy');
});

// products routes
Route::controller(ProductController::class)->prefix('product/')->name('product.')->group(function (){
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{product}/edit', 'edit')->name('edit');
    Route::put('/{product}', 'update')->name('update');
    Route::delete('/{product}', 'destroy')->name('destroy');
});

// orders routes
Route::controller(OrderController::class)->prefix('order/')->name('order.')->group(function (){
    Route::get('/', 'index')->name('index');
    Route::get('/{order}', 'show')->name('show');
    Route::patch('/{order}/status', 'updateStatus')->name('updateStatus');
});

// settings route
Route::controller(SettingController::class)->prefix('setting/')->name('setting.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
});

// logout route
Route::controller(AdminAuthController::class)->name('auth.')->group(function () {
    Route::post('logout', 'logout')->name('logout');
});
