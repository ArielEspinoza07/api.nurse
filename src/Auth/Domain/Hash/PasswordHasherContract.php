<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Hash;

use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserPassword;

interface PasswordHasherContract
{
    public function hash(AuthUserPassword $password): string;

    public function check(AuthUser $user, AuthUserPassword $password): bool;
}
