<?php

declare(strict_types=1);

namespace Src\Auth\Application\Authenticate;

use Src\Auth\Application\AuthUserResponse;
use Src\Auth\Domain\AuthPlainTextToken;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\Repository\AuthTokenRepository;
use Src\Auth\Domain\Exception\InvalidAuthUserPasswordException;
use Src\Auth\Domain\Hash\PasswordHasherContract;
use Src\Auth\Domain\Repository\AuthUserRepository;
use Src\shared\Domain\Token\TokenContract;

class AuthenticateUser
{
    public function __construct(
        private readonly AuthTokenRepository $authTokenRepository,
        private readonly AuthUserRepository $authUserRepository,
        private readonly PasswordHasherContract $passwordHasher,
        private readonly TokenContract $tokenService
    ) {
    }

    public function handle(AuthUserEmail $email, AuthUserPassword $password): AuthUserResponse
    {
        $authUser = $this->authUserRepository->findByEmail($email);

        if (!$this->passwordHasher->check($authUser, $password)) {
            throw new InvalidAuthUserPasswordException($email->emailAddress());
        }

        $authToken = $this->authTokenRepository->create(
            AuthPlainTextToken::create($this->tokenService->generate()),
            $authUser
        );

        return new AuthUserResponse($authToken->id()->value(), $authToken->plainText()->value());
    }
}
