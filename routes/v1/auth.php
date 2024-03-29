<?php

use Illuminate\Support\Facades\Route;
use Src\Auth\Infrastructure\Http\Controllers\Rest\AuthenticateUserController;
use Src\Auth\Infrastructure\Http\Controllers\Rest\DeauthenticateUserController;
use Src\Auth\Infrastructure\Http\Controllers\Rest\GetAuthenticatedUserByIdController;
use Src\Auth\Infrastructure\Http\Controllers\Rest\RegisterUserController;
use Src\Auth\Infrastructure\Http\Controllers\Rest\VerifyUserController;

Route::prefix('auth')
    ->as('auth:')
    ->group(function () {
        Route::withoutMiddleware(['auth:sanctum'])
            ->group(function () {
                Route::post('/login', AuthenticateUserController::class)->name('login');
                Route::post('/register', RegisterUserController::class)->name('register');
            });
        Route::post('/user', GetAuthenticatedUserByIdController::class)->name('user');
        Route::post('/logout', DeauthenticateUserController::class)->name('logout');
        Route::post('/verify/{id}', VerifyUserController::class)->name('verify');
    });
