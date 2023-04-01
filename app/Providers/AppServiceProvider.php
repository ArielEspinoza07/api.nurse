<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthTokenModel;

class AppServiceProvider extends ServiceProvider
{
    private array $providers = [
        \Src\Auth\Infrastructure\Providers\AuthUserBindingServiceProvider::class,
        \Src\BackOffice\MedicalService\Infrastructure\Providers\MedicalServiceBindingServiceProvider::class,
        \Src\shared\Infrastructure\Providers\SharedBindingServiceProvider::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations();
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(EloquentAuthTokenModel::class);
    }
}
