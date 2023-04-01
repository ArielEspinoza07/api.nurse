<?php

namespace Tests\Unit\src\Auth\Application;

use Illuminate\Support\Str;
use Mockery;
use Src\Auth\Application\Authenticate\AuthenticateUser;
use Src\Auth\Application\AuthUserResponse;
use Src\Auth\Domain\AuthPlainTextToken;
use Src\Auth\Domain\AuthTokenId;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\AuthToken;
use Src\Auth\Domain\Repository\AuthTokenRepository;
use Src\Auth\Domain\Hash\PasswordHasherContract;
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

        $authToken = AuthToken::create(
            AuthTokenId::create(1),
            AuthPlainTextToken::create(Str::random(40)),
            $authUser
        );

        $userRepository = Mockery::mock(AuthUserRepository::class);
        $this->app->instance(AuthenticateUser::class, $userRepository);

        $userRepository->shouldReceive('findByEmail')
            ->once()
            ->with(
                Mockery::on(function (AuthUserEmail $email) use ($authUser) {
                    return $authUser->email()->value() === $email->value();
                })
            )
            ->andReturn($authUser);

        $passwordHasher = Mockery::mock(PasswordHasherContract::class);
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

        $authTokenRepository = Mockery::mock(AuthTokenRepository::class);
        $this->app->instance(AuthenticateUser::class, $authTokenRepository);

        $authTokenRepository->shouldReceive('create')
            ->once()
            ->with(
                Mockery::on(function (AuthUser $user) use ($authUser) {
                    return $authUser->id()->value() === $user->id()->value()
                        && $authUser->name()->value() === $user->name()->value()
                        && $authUser->email()->value() === $user->email()->value();
                }),
            )
            ->andReturn($authToken);

        $response = (new AuthenticateUser($authTokenRepository, $userRepository, $passwordHasher))
            ->handle(
                AuthUserEmail::createNotVerified($payload['email']),
                AuthUserPassword::create($payload['password']),
            );

        $this->assertInstanceOf(AuthUserResponse::class, $response);
    }
}
