<?php

declare(strict_types=1);

namespace Src\Auth\Application\Deauthenticate;

use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\Repository\AuthTokenRepository;

class DeauthenticateUser
{
    public function __construct(
        private readonly AuthTokenRepository $repository,
    ) {
    }


    public function handle(AuthUserId $id): void
    {
        $authToken = $this->repository->findByUserId($id);

        $this->repository->delete($authToken);
    }
}
