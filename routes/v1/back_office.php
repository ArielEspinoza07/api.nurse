<?php

use Illuminate\Support\Facades\Route;
use Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest\CreateMedicalServiceController;
use Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest\DeleteMedicalServiceController;
use Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest\GetByIdMedicalServiceController;
use Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest\SearchMedicalServiceController;
use Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest\UpdateMedicalServiceController;

Route::prefix('medical')
    ->as('medical:')
    ->group(function () {
        Route::prefix('service')
            ->as('service:')
            ->group(function () {
                Route::get('/', SearchMedicalServiceController::class)->name('index');
                Route::post('/', CreateMedicalServiceController::class)->name('create');
                Route::get('/{id}', GetByIdMedicalServiceController::class)->name('show');
                Route::put('/{id}', UpdateMedicalServiceController::class)->name('update');
                Route::delete('/{id}', DeleteMedicalServiceController::class)->name('delete');
            });
    });
