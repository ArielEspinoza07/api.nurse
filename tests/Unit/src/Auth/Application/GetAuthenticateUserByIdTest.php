<?php

namespace Tests\Unit\src\Auth\Application;

use Mockery;
use Src\Auth\Application\Find\GetAuthenticateUserById;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\Repository\AuthUserRepository;
use Tests\Unit\src\Auth\AuthApplicationTestBase;

class GetAuthenticateUserByIdTest extends AuthApplicationTestBase
{
    public function test_return_auth_user(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'j.doe@gmail.com',
            'password' => 'J.Doe1889',
        ];

        $authUser = $this->createAutUser($payload);

        $userRepository = Mockery::mock(AuthUserRepository::class);
        $this->app->instance(GetAuthenticateUserById::class, $userRepository);

        $userRepository->shouldReceive('findById')
            ->once()
            ->with(
                Mockery::on(function (AuthUserId $id) use ($authUser) {
                    return $authUser->id()->value() === $id->value();
                })
            )
            ->andReturn($authUser);

        $response = (new GetAuthenticateUserById($userRepository))
            ->handle(
                $authUser->id()
            );

        $this->assertInstanceOf(AuthUser::class, $response);
    }
}
