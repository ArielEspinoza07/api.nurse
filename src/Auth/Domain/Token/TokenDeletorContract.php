<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Token;

use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserToken;

interface TokenDeletorContract
{
    public function delete(AuthUser $user): void;
}
