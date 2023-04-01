<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Repository;

use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\AuthToken;
use Src\Auth\Domain\AuthUser;

interface AuthTokenRepository
{
    public function create(AuthUser $user): AuthToken;

    public function delete(AuthToken $token): void;

    public function findByUserId(AuthUserId $id): AuthToken;
}
