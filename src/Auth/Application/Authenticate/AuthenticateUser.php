<?php

declare(strict_types=1);

namespace Src\Auth\Application\Authenticate;

use Src\Auth\Application\AuthUserResponse;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\Repository\AuthTokenRepository;
use Src\Auth\Domain\Exception\InvalidAuthUserPasswordException;
use Src\Auth\Domain\Hash\PasswordHasherContract;
use Src\Auth\Domain\Repository\AuthUserRepository;

class AuthenticateUser
{
    public function __construct(
        private readonly AuthTokenRepository $authTokenRepository,
        private readonly AuthUserRepository $authUserRepository,
        private readonly PasswordHasherContract $passwordHasher
    ) {
    }

    public function handle(AuthUserEmail $email, AuthUserPassword $password): AuthUserResponse
    {
        $authUser = $this->authUserRepository->findByEmail($email);

        if (!$this->passwordHasher->check($authUser, $password)) {
            throw new InvalidAuthUserPasswordException($email);
        }

        $authToken = $this->authTokenRepository->create($authUser);

        return new AuthUserResponse($authToken->id()->value(), $authToken->plainTextToken()->value());
    }
}
