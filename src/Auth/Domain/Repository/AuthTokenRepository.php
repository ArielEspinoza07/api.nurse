<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Repository;

use Src\Auth\Domain\AuthPlainTextToken;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\AuthToken;
use Src\Auth\Domain\AuthUser;

interface AuthTokenRepository
{
    public function create(AuthPlainTextToken $plainTextToken, AuthUser $user): AuthToken;

    public function delete(AuthToken $token): void;

    public function findByUserId(AuthUserId $id): AuthToken;
}
