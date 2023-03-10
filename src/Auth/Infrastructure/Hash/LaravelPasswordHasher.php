<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Hash;

use Illuminate\Support\Facades\Hash;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\Contracts\PasswordHasherInterface;

class LaravelPasswordHasher implements PasswordHasherInterface
{
    public function hash(AuthUserPassword $password): string
    {
        return Hash::make($password->value());
    }

    public function check(AuthUser $user, AuthUserPassword $password): bool
    {
        return Hash::check($password->value(), $user->password()->value());
    }
}
