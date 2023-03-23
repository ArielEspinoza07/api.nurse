<?php

declare(strict_types=1);

namespace Src\Auth\Application\Verify;

use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\Exception\AuthUserEmailAlreadyVerifiedException;
use Src\Auth\Domain\Repository\AuthUserRepository;

class VerifyUser
{
    public function __construct(private readonly AuthUserRepository $repository)
    {
    }

    public function handle(AuthUserId $id): void
    {
        $authUser = $this->repository->findById($id);
        if ($authUser->email()->emailVerify()->isVerified()) {
            throw new AuthUserEmailAlreadyVerifiedException();
        }
        $this->repository->verifyEmail($authUser);
    }
}
