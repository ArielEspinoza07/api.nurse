<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Contracts;

use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserToken;

interface TokenCreatorInterface
{
    public function create(AuthUser $user): AuthUserToken;
}
