<?php

namespace Tests\Unit\src\Auth\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Src\Auth\Application\Register\RegisterUser;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\AuthUserToken;
use Src\Auth\Domain\Token\TokenCreatorContract;
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

        $encryptedAuthUser = AuthUser::createFromNameEmailAndPassword(
            $name,
            $email,
            $encryptedPassword
        );

        $repository = Mockery::mock(AuthUserRepository::class);
        $this->app->instance(RegisterUser::class, $repository);
        $repository->shouldReceive('create')
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

        $tokenCreator = Mockery::mock(TokenCreatorContract::class);
        $this->app->instance(RegisterUser::class, $tokenCreator);

        $tokenCreator->shouldReceive('create')
            ->once()
            ->with(
                Mockery::on(function (AuthUser $user) use ($encryptedAuthUser) {
                    return $encryptedAuthUser->id()->value() === $user->id()->value()
                        && $encryptedAuthUser->email()->value() === $user->email()->value()
                        && $encryptedAuthUser->name()->value() === $user->name()->value();
                })
            )
            ->andReturn(AuthUserToken::create($this->fakeToken));

        $token = (new RegisterUser($repository, $passwordHasher, $tokenCreator))
            ->handle(
                $name,
                $email,
                $notEncryptedPassword
            );

        $this->assertInstanceOf(AuthUserToken::class, $token);
        $this->assertEquals(AuthUserToken::TOKEN_LENGTH, strlen($token->value()));
    }
}
