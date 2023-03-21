<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Token;

use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserToken;

interface TokenCreatorContract
{
    public function create(AuthUser $user): AuthUserToken;
}
