<?php

namespace Tests\Unit\src\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Auth\Application\AuthUserResponse;
use Src\Auth\Application\Register\RegisterUser;
use Src\Auth\Domain\AuthToken;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Infrastructure\Hash\LaravelPasswordHasher;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthTokenRepository;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthUserModel;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthUserRepository;
use Tests\TestCase;

class AuthApplicationTestBase extends TestCase
{
    use RefreshDatabase;

    protected string $fakeToken = '1|h0F5Nkx4vAjjPrmJw3RMDX9AH81kgl3xZVZoEzgi';

    protected function createAutUser(array $payload): AuthUser
    {
        $model = EloquentAuthUserModel::query()->create(
            [
                'name' => $payload['name'],
                'email' => $payload['email'],
                'password' => (new LaravelPasswordHasher())
                    ->hash(AuthUserPassword::create($payload['password'])),
            ]
        );

        return AuthUser::create(
            AuthUserId::create($model->id),
            AuthUserName::create($model->name),
            AuthUserEmail::createNotVerified($model->email),
            AuthUserPassword::create($model->password),
        );
    }

    protected function registerUser(string $name, string $email, string $password): AuthUserResponse
    {
        return (new RegisterUser(
            new EloquentAuthTokenRepository(),
            new EloquentAuthUserRepository(),
            new LaravelPasswordHasher()
        ))->handle(
            AuthUserName::create($name),
            AuthUserEmail::createNotVerified($email),
            AuthUserPassword::create($password)
        );
    }
}
