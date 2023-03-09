<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Auth\Domain\Contracts\PasswordHasherInterface;
use Src\Auth\Domain\Contracts\TokenCreatorInterface;
use Src\Auth\Domain\Contracts\TokenDeletorInterface;
use Src\Auth\Domain\Repository\AuthUserRepository;
use Src\Auth\Infrastructure\Hash\LaravelPasswordHasher;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthUserRepository;
use Src\Auth\Infrastructure\Token\LaravelSanctumToken;

class AuthUserBindingServiceProvider extends ServiceProvider
{

    public array $bindings = [
        AuthUserRepository::class => EloquentAuthUserRepository::class,
        PasswordHasherInterface::class => LaravelPasswordHasher::class,
        TokenCreatorInterface::class => LaravelSanctumToken::class,
        TokenDeletorInterface::class => LaravelSanctumToken::class,
    ];


    public function register(): void
    {
    }


    public function boot(): void
    {
    }
}
