<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Contracts;

use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserToken;

interface TokenDeletorInterface
{
    public function delete(AuthUser $user): void;
}
