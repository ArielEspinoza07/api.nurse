<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Repository;

use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;

interface AuthUserRepository
{
    public function create(
        AuthUserName $name,
        AuthUserEmail $email,
        AuthUserPassword $password
    );


    public function findByEmail(AuthUserEmail $authUserEmail): AuthUser;


    public function findById(AuthUserId $id): AuthUser;

    public function verifyEmail(AuthUser $user): void;
}
