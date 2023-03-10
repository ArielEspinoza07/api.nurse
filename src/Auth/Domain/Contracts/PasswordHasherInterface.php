<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Contracts;

use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserPassword;

interface PasswordHasherInterface
{
    public function hash(AuthUserPassword $password): string;

    public function check(AuthUser $user, AuthUserPassword $password): bool;
}
