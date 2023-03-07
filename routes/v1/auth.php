<?php

use Illuminate\Support\Facades\Route;
use Src\Auth\Infrastructure\Http\Controllers\Rest\AuthenticateUserController;
use Src\Auth\Infrastructure\Http\Controllers\Rest\RegisterUserController;

Route::prefix('auth')
    ->as('auth:')
    ->group(function () {
        Route::withoutMiddleware(['auth:sanctum'])
            ->group(function () {
                Route::post('/login', AuthenticateUserController::class)->name('login');
                Route::post('/register', RegisterUserController::class)->name('register');
            });
    });
