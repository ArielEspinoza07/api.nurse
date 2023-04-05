<?php

namespace Tests\Unit\src\Auth\Application;

use Mockery;
use Src\Auth\Application\Authenticate\AuthenticateUser;
use Src\Auth\Application\Deauthenticate\DeauthenticateUser;
use Src\Auth\Domain\AuthPlainTextToken;
use Src\Auth\Domain\AuthToken;
use Src\Auth\Domain\AuthTokenId;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\Repository\AuthTokenRepository;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthUserRepository;
use Src\shared\Domain\EmailAddress;
use Tests\Unit\src\Auth\AuthApplicationTestBase;

class DeauthenticateTest extends AuthApplicationTestBase
{
    public function test_user_deauthenticator(): void
    {
        $name = 'John Doe';
        $email = 'j.doe@gmail.com';
        $password = 'J.Doe1889';

        $authUserResponse = $this->registerUser($name, $email, $password);

        $authToken = AuthToken::create(
            AuthTokenId::create($authUserResponse->id()),
            AuthPlainTextToken::create($authUserResponse->token()),
            (new EloquentAuthUserRepository())
                ->findByEmail(AuthUserEmail::createNotVerified(EmailAddress::create($email)))
        );

        $authTokenRepository = Mockery::mock(AuthTokenRepository::class);
        $this->app->instance(AuthenticateUser::class, $authTokenRepository);

        $authTokenRepository->shouldReceive('findByUserId')
            ->once()
            ->with(
                Mockery::on(function (AuthUserId $id) use ($authToken) {
                    return $authToken->id()->value() === $id->value();
                }),
            )
            ->andReturn($authToken);

        $authTokenRepository->shouldReceive('delete')
            ->once()
            ->with(
                Mockery::on(function (AuthToken $token) use ($authToken) {
                    return $authToken->id()->value() === $token->id()->value()
                        && $authToken->plainTextToken()->value() === $token->plainTextToken()->value()
                        && $authToken->user()->id()->value() === $token->user()->id()->value();
                }),
            )
            ->andReturn();

        (new DeauthenticateUser($authTokenRepository))->handle(
            $authToken->user()->id(),
        );
    }
}
