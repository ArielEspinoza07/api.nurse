<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Auth\Domain\Token\TokenCreatorContract;
use Src\Auth\Domain\Token\TokenDeletorContract;
use Src\Auth\Domain\Hash\PasswordHasherContract;
use Src\Auth\Domain\Repository\AuthUserRepository;
use Src\Auth\Infrastructure\Hash\LaravelPasswordHasher;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthUserRepository;
use Src\Auth\Infrastructure\Token\LaravelSanctumToken;

class AuthUserBindingServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AuthUserRepository::class => EloquentAuthUserRepository::class,
        PasswordHasherContract::class => LaravelPasswordHasher::class,
        TokenCreatorContract::class => LaravelSanctumToken::class,
        TokenDeletorContract::class => LaravelSanctumToken::class,
    ];


    public function register(): void
    {
    }


    public function boot(): void
    {
    }
}
