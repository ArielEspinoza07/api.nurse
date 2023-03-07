<?php

namespace App\Providers;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\Contract\ResponseContract;
use App\Services\Rest\Json\Contract\ResponseExceptionHandlerContract;
use App\Services\Rest\Json\Response;
use App\Services\Rest\Json\ResponseBuilder;
use App\Services\Rest\Json\ResponseExceptionHandler;
use Illuminate\Support\ServiceProvider;

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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
