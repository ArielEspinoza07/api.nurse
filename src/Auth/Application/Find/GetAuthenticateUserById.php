<?php

declare(strict_types=1);

namespace Src\Auth\Application\Find;

use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\Repository\AuthUserRepository;

class GetAuthenticateUserById
{
    public function __construct(private readonly AuthUserRepository $repository)
    {
    }

    public function handle(AuthUserId $id): AuthUser
    {
        return $this->repository->findById($id);
    }
}
