<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Auth\AdminAuthController;


Route::get('{local}', function (){
    return to_route('dashboard.welcome', ['locale' => app()->getLocale()]);
});
