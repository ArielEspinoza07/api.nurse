<?php

namespace Tests\Unit\src\Auth\Application;

use Mockery;
use Src\Auth\Application\Verify\VerifyUser;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\Repository\AuthUserRepository;
use Tests\Unit\src\Auth\AuthApplicationTestBase;

class VerifyUserTest extends AuthApplicationTestBase
{

    public function test_verify_user(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'j.doe@gmail.com',
            'password' => 'J.Doe1889',
        ];
        $authUser = $this->createAutUser($payload);

        $repository = Mockery::mock(AuthUserRepository::class);
        $this->app->instance(VerifyUser::class, $repository);

        $repository->shouldReceive('findById')
            ->once()
            ->with(
                Mockery::on(function (AuthUserId $id) use ($authUser) {
                    return $authUser->id()->value() === $id->value();
                })
            )
            ->andReturn($authUser);

        $repository->shouldReceive('verifyEmail')
            ->once()
            ->with(
                Mockery::on(function (AuthUser $user) use ($authUser) {
                    return $authUser->id()->value() === $user->id()->value()
                        && $authUser->name()->value() === $user->name()->value()
                        && $authUser->email()->value() === $user->email()->value();
                })
            )
            ->andReturn();

        (new VerifyUser($repository))->handle($authUser->id());
    }
}
