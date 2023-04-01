<?php

namespace Tests\Unit\src\Auth\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Mockery;
use Src\Auth\Application\Authenticate\AuthenticateUser;
use Src\Auth\Application\AuthUserResponse;
use Src\Auth\Application\Register\RegisterUser;
use Src\Auth\Domain\AuthPlainTextToken;
use Src\Auth\Domain\AuthTokenId;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\AuthToken;
use Src\Auth\Domain\Repository\AuthTokenRepository;
use Src\Auth\Domain\Hash\PasswordHasherContract;
use Src\Auth\Domain\Repository\AuthUserRepository;
use Src\Auth\Infrastructure\Hash\LaravelPasswordHasher;
use Tests\Unit\src\Auth\AuthApplicationTestBase;

class RegisterTest extends AuthApplicationTestBase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_register_user(): void
    {
        $name = AuthUserName::create($this->faker->name());
        $email = AuthUserEmail::createNotVerified($this->faker->email());
        $notEncryptedPassword = AuthUserPassword::create('Password!1');
        $encryptedPassword = AuthUserPassword::create((new LaravelPasswordHasher())->hash($notEncryptedPassword));

        $encryptedAuthUser = AuthUser::createFromNameEmailAndPassword(
            $name,
            $email,
            $encryptedPassword
        );

        $authToken = AuthToken::create(
            AuthTokenId::create(1),
            AuthPlainTextToken::create(Str::random(40)),
            $encryptedAuthUser
        );

        $passwordHasher = Mockery::mock(PasswordHasherContract::class);
        $this->app->instance(RegisterUser::class, $passwordHasher);

        $passwordHasher->shouldReceive('hash')
            ->once()
            ->with(
                Mockery::on(function (AuthUserPassword $password) use ($notEncryptedPassword) {
                    return $notEncryptedPassword->value() === $password->value();
                })
            )
            ->andReturn($encryptedPassword->value());

        $authUserRepository = Mockery::mock(AuthUserRepository::class);
        $this->app->instance(RegisterUser::class, $authUserRepository);

        $authUserRepository->shouldReceive('create')
            ->once()
            ->with(
                Mockery::on(function (AuthUserName $name) use ($encryptedAuthUser) {
                    return $name->value() === $encryptedAuthUser->name()->value();
                }),
                Mockery::on(function (AuthUserEmail $email) use ($encryptedAuthUser) {
                    return $email->value() === $encryptedAuthUser->email()->value();
                }),
                Mockery::on(function (AuthUserPassword $password) use ($encryptedAuthUser) {
                    return $password->value() === $encryptedAuthUser->password()->value();
                })
            )
            ->andReturn($encryptedAuthUser);

        $authTokenRepository = Mockery::mock(AuthTokenRepository::class);
        $this->app->instance(AuthenticateUser::class, $authTokenRepository);

        $authTokenRepository->shouldReceive('create')
            ->once()
            ->with(
                Mockery::on(function (AuthUser $user) use ($encryptedAuthUser) {
                    return $encryptedAuthUser->id()->value() === $user->id()->value()
                        && $encryptedAuthUser->name()->value() === $user->name()->value()
                        && $encryptedAuthUser->email()->value() === $user->email()->value();
                }),
            )
            ->andReturn($authToken);

        $response = (new RegisterUser($authTokenRepository, $authUserRepository, $passwordHasher))
            ->handle(
                $name,
                $email,
                $notEncryptedPassword
            );

        $this->assertInstanceOf(AuthUserResponse::class, $response);
    }
}
