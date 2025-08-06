<?php

use App\Http\Controllers\Auth\AuthController as AuthAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthAuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthAuthController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthAuthController::class, 'destroy'])->name('logout');
});
