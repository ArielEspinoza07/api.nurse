<?php

namespace Src\Auth\Application\Deauthenticate;

use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\Contracts\TokenDeletorInterface;
use Src\Auth\Domain\Repository\AuthUserRepository;

class DeauthenticateUser
{
    public function __construct(
        private readonly AuthUserRepository $repository,
        private readonly TokenDeletorInterface $tokenDeletor
    ) {
    }


    public function handle(AuthUserId $id): void
    {
        $this->tokenDeletor
            ->delete($this->repository->findById($id));
    }
}
