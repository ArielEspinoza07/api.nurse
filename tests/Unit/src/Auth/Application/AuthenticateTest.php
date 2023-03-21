<?php

namespace Tests\Unit\src\Auth\Application;

use Mockery;
use Src\Auth\Application\Authenticate\AuthenticateUser;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\AuthUserToken;
use Src\Auth\Domain\Contracts\TokenCreatorInterface;
use Src\Auth\Domain\Hash\PasswordHasherInterface;
use Src\Auth\Domain\Repository\AuthUserRepository;
use Tests\Unit\src\Auth\AuthApplicationTestBase;


class AuthenticateTest extends AuthApplicationTestBase
{
    public function test_user_authenticator_return_auth_user_token(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'j.doe@gmail.com',
            'password' => 'J.Doe1889',
        ];
        $authUser = $this->createAutUser($payload);

        $repository = Mockery::mock(AuthUserRepository::class);
        $this->app->instance(AuthenticateUser::class, $repository);

        $repository->shouldReceive('findByEmail')
            ->once()
            ->with(
                Mockery::on(function (AuthUserEmail $email) use ($authUser) {
                    return $authUser->email()->value() === $email->value();
                })
            )
            ->andReturn($authUser);

        $passwordHasher = Mockery::mock(PasswordHasherInterface::class);
        $this->app->instance(AuthenticateUser::class, $passwordHasher);

        $passwordHasher->shouldReceive('check')
            ->once()
            ->with(
                Mockery::on(function (AuthUser $user) use ($authUser) {
                    return $authUser->id()->value() === $user->id()->value()
                        && $authUser->email()->value() === $user->email()->value();
                }),
                Mockery::on(function (AuthUserPassword $password) use ($payload) {
                    return $payload['password'] === $password->value();
                }),
            )
            ->andReturn(true);

        $tokenCreator = Mockery::mock(TokenCreatorInterface::class);
        $this->app->instance(AuthenticateUser::class, $tokenCreator);

        $tokenCreator->shouldReceive('create')
            ->once()
            ->with(
                Mockery::on(function (AuthUser $user) use ($authUser) {
                    return $authUser->id()->value() === $user->id()->value()
                        && $authUser->email()->value() === $user->email()->value();
                })
            )
            ->andReturn(AuthUserToken::create($this->tokenExample));

        $token = (new AuthenticateUser($repository, $passwordHasher, $tokenCreator))
            ->handle(
                AuthUserEmail::create($payload['email']),
                AuthUserPassword::create($payload['password']),
            );

        $this->assertInstanceOf(AuthUserToken::class, $token);
        $this->assertEquals(AuthUserToken::TOKEN_LENGTH, strlen($token->value()));
    }
}
