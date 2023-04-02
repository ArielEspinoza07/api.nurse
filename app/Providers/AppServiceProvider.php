<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthTokenModel;
use Src\shared\Infrastructure\Providers\SharedRegisterServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations();
        $this->app->register(SharedRegisterServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(EloquentAuthTokenModel::class);
    }
}
