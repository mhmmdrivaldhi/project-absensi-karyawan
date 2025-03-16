<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['employee.direct.login'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logoutProcess']);
});

Route::middleware(['employee.direct.logout'])->group(function(){
    Route::get('/', [AuthController::class, 'index']);
    Route::post('/login', [AuthController::class, 'loginProcess']);
});

