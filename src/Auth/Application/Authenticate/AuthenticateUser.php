<?php

declare(strict_types=1);

namespace Src\Auth\Application\Authenticate;

use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\AuthUserToken;
use Src\Auth\Domain\Contracts\TokenCreatorInterface;
use Src\Auth\Domain\Exception\InvalidAuthUserPasswordException;
use Src\Auth\Domain\Hash\PasswordHasherInterface;
use Src\Auth\Domain\Repository\AuthUserRepository;

class AuthenticateUser
{
    public function __construct(
        private readonly AuthUserRepository $repository,
        private readonly PasswordHasherInterface $passwordHasher,
        private readonly TokenCreatorInterface $tokenCreator
    ) {
    }

    public function handle(AuthUserEmail $email, AuthUserPassword $password): AuthUserToken
    {
        $authUser = $this->repository->findByEmail($email);

        if (!$this->passwordHasher->check($authUser, $password)) {
            throw new InvalidAuthUserPasswordException($email);
        }

        return $this->tokenCreator->create($authUser);
    }
}
