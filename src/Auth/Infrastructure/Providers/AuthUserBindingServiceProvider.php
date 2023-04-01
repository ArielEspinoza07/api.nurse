<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Auth\Domain\Repository\AuthTokenRepository;
use Src\Auth\Domain\Hash\PasswordHasherContract;
use Src\Auth\Domain\Repository\AuthUserRepository;
use Src\Auth\Infrastructure\Hash\LaravelPasswordHasher;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthTokenRepository;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthUserRepository;

class AuthUserBindingServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AuthUserRepository::class => EloquentAuthUserRepository::class,
        PasswordHasherContract::class => LaravelPasswordHasher::class,
        AuthTokenRepository::class => EloquentAuthTokenRepository::class,
    ];


    public function register(): void
    {
    }


    public function boot(): void
    {
    }
}
