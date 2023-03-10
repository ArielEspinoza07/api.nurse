<?php

namespace Tests\Unit\src\Auth\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Mockery;
use Src\Auth\Application\Register\RegisterUser;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\AuthUserToken;
use Src\Auth\Domain\Contracts\PasswordHasherInterface;
use Src\Auth\Domain\Contracts\TokenCreatorInterface;
use Src\Auth\Domain\Repository\AuthUserRepository;
use Tests\Unit\src\Auth\AuthApplicationTestBase;

class RegisterTest extends AuthApplicationTestBase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_register_user(): void
    {
        $name = new AuthUserName($this->faker->name());
        $email = new AuthUserEmail($this->faker->email());
        $notEncryptedPassword = new AuthUserPassword('Password!1');

        $notEncryptedAuthUser = AuthUser::createFromNameEmailAndPassword($name, $email, $notEncryptedPassword);

        $passwordHasher = Mockery::mock(PasswordHasherInterface::class);
        $this->app->instance(RegisterUser::class, $passwordHasher);

        $passwordHasher->shouldReceive('hash')
            ->once()
            ->with(
                Mockery::on(function (AuthUserPassword $password) use ($notEncryptedPassword) {
                    return $notEncryptedPassword->value() === $password->value();
                })
            )
            ->andReturn($this->tokenExample);

        $repository = Mockery::mock(AuthUserRepository::class);
        $this->app->instance(RegisterUser::class, $repository);
        $repository->shouldReceive('create')
            ->once()
            ->with(
                Mockery::on(function (AuthUserName $name) use ($notEncryptedAuthUser) {
                    return $name->value() === $notEncryptedAuthUser->name()->value();
                }),
                Mockery::on(function (AuthUserEmail $email) use ($notEncryptedAuthUser) {
                    return $email->value() === $notEncryptedAuthUser->email()->value();
                }),
                Mockery::on(function (AuthUserPassword $password) {
                    return $password->value() !== null;
                })
            )
            ->andReturn($notEncryptedAuthUser);

        $tokenCreator = Mockery::mock(TokenCreatorInterface::class);
        $this->app->instance(RegisterUser::class, $tokenCreator);

        $tokenCreator->shouldReceive('create')
            ->once()
            ->with(
                Mockery::on(function (AuthUser $user) use ($notEncryptedAuthUser) {
                    return $notEncryptedAuthUser->id()->value() === $user->id()->value()
                        && $notEncryptedAuthUser->email()->value() === $user->email()->value()
                        && $notEncryptedAuthUser->name()->value() === $user->name()->value();
                })
            )
            ->andReturn(new AuthUserToken($this->tokenExample));

        $token = (new RegisterUser($repository, $passwordHasher, $tokenCreator))
            ->handle(
                $name,
                $email,
                $notEncryptedPassword
            );

        $this->assertInstanceOf(AuthUserToken::class, $token);
        $this->assertEquals(strlen($this->tokenExample), strlen($token->value()));
    }
}
