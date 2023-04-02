<?php

declare(strict_types=1);

namespace Src\Auth\Application\Register;

use Src\Auth\Application\AuthUserResponse;
use Src\Auth\Domain\AuthPlainTextToken;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\Repository\AuthTokenRepository;
use Src\Auth\Domain\Hash\PasswordHasherContract;
use Src\Auth\Domain\Repository\AuthUserRepository;
use Src\shared\Domain\Token\TokenContract;

class RegisterUser
{
    public function __construct(
        private readonly AuthTokenRepository $authTokenRepository,
        private readonly AuthUserRepository $authUserRepository,
        private readonly PasswordHasherContract $passwordHasher,
        private readonly TokenContract $tokenService
    ) {
    }

    public function handle(AuthUserName $name, AuthUserEmail $email, AuthUserPassword $password): AuthUserResponse
    {
        $user = $this->authUserRepository
            ->create(
                $name,
                $email,
                AuthUserPassword::create($this->passwordHasher->hash($password))
            );

        $authToken = $this->authTokenRepository->create(
            AuthPlainTextToken::create($this->tokenService->generate()),
            $user
        );

        return new AuthUserResponse($authToken->id()->value(), $authToken->plainTextToken()->value());
    }
}
