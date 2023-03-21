<?php

declare(strict_types=1);

namespace Src\Auth\Application\Register;

use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\AuthUserToken;
use Src\Auth\Domain\Token\TokenCreatorContract;
use Src\Auth\Domain\Hash\PasswordHasherContract;
use Src\Auth\Domain\Repository\AuthUserRepository;

class RegisterUser
{
    public function __construct(
        private readonly AuthUserRepository $repository,
        private readonly PasswordHasherContract $passwordHasher,
        private readonly TokenCreatorContract $tokenCreator,
    ) {
    }

    public function handle(AuthUserName $name, AuthUserEmail $email, AuthUserPassword $password): AuthUserToken
    {
        return $this->tokenCreator
            ->create(
                $this->repository
                    ->create(
                        $name,
                        $email,
                        AuthUserPassword::create($this->passwordHasher->hash($password))
                    )
            );
    }
}
