<?php

namespace Tests\Unit\src\Auth\Application;

use Mockery;
use Src\Auth\Application\Authenticate\AuthenticateUser;
use Src\Auth\Application\Deauthenticate\DeauthenticateUser;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\AuthUserToken;
use Src\Auth\Domain\Token\TokenDeletorContract;
use Src\Auth\Domain\Repository\AuthUserRepository;
use Src\Auth\Infrastructure\Hash\LaravelPasswordHasher;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthUserRepository;
use Src\Auth\Infrastructure\Token\LaravelSanctumToken;
use Tests\Unit\src\Auth\AuthApplicationTestBase;

class DeauthenticateTest extends AuthApplicationTestBase
{

    public function test_user_deauthenticator(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'j.doe@gmail.com',
            'password' => 'J.Doe1889',
        ];

        $authUser = $this->createAutUser($payload);

        $token = (new AuthenticateUser(
            new EloquentAuthUserRepository(),
            new LaravelPasswordHasher(),
            new LaravelSanctumToken()
        ))->handle(
            AuthUserEmail::create($payload['email']),
            AuthUserPassword::create($payload['password']),
        );

        $this->assertInstanceOf(AuthUserToken::class, $token);
        $this->assertEquals(AuthUserToken::TOKEN_LENGTH, strlen($token->value()));

        $repository = Mockery::mock(AuthUserRepository::class);
        $this->app->instance(AuthenticateUser::class, $repository);

        $repository->shouldReceive('findById')
            ->once()
            ->with(
                Mockery::on(function (AuthUserId $id) use ($authUser) {
                    return $authUser->id()
                            ->value() === $id->value();
                })
            )
            ->andReturn($authUser);

        $tokenCreator = Mockery::mock(TokenDeletorContract::class);
        $this->app->instance(AuthenticateUser::class, $tokenCreator);

        $tokenCreator->shouldReceive('delete')
            ->once()
            ->with(
                Mockery::on(function (AuthUser $user) use ($authUser) {
                    return $authUser->id()->value() === $user->id()->value()
                        && $authUser->email()->value() === $user->email()->value();
                })
            );

        (new DeauthenticateUser($repository, $tokenCreator))->handle(
            $authUser->id(),
        );
    }
}
