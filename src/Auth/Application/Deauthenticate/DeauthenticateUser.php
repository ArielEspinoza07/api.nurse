<?php

declare(strict_types=1);

namespace Src\Auth\Application\Deauthenticate;

use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\Token\TokenDeletorContract;
use Src\Auth\Domain\Repository\AuthUserRepository;

class DeauthenticateUser
{
    public function __construct(
        private readonly AuthUserRepository $repository,
        private readonly TokenDeletorContract $tokenDeletor
    ) {
    }


    public function handle(AuthUserId $id): void
    {
        $this->tokenDeletor
            ->delete($this->repository->findById($id));
    }
}
