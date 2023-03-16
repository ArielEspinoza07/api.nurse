<?php

namespace App\Providers;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\Contract\ResponseContract;
use App\Services\Rest\Json\Contract\ResponseExceptionHandlerContract;
use App\Services\Rest\Json\Exception\ResponseExceptionHandler;
use App\Services\Rest\Json\Response;
use App\Services\Rest\Json\ResponseBuilder;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthTokenModel;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        ResponseBuilderContract::class => ResponseBuilder::class,
        ResponseContract::class => Response::class,
        ResponseExceptionHandlerContract::class => ResponseExceptionHandler::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(EloquentAuthTokenModel::class);
    }
}
