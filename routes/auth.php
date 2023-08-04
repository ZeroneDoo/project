<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, "login"])->name('auth.login');
    Route::post('/login', [AuthController::class, "storeLogin"])->name('auth.store.login');
});
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
