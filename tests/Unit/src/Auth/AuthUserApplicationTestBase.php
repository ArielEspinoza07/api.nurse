<?php

namespace Tests\Unit\src\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\AuthUserToken;
use Src\Auth\Infrastructure\Hash\LaravelPasswordHasher;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthUserModel;
use Tests\TestCase;

class AuthUserApplicationTestBase extends TestCase
{
    use RefreshDatabase;

    protected string $tokenExample = '1|h0F5Nkx4vAjjPrmJw3RMDX9AH81kgl3xZVZoEzgi';

    protected function createAutUser(array $payload): AuthUser
    {
        $model = EloquentAuthUserModel::query()->create(
            [
                'name' => $payload['name'],
                'email' => $payload['email'],
                'password' => (new LaravelPasswordHasher())
                    ->hash(new AuthUserPassword($payload['password'])),
            ]
        );

        return AuthUser::create(
            new AuthUserId($model->id),
            new AuthUserName($model->name),
            new AuthUserEmail($model->email),
            new AuthUserPassword($model->password),
            new AuthUserToken(''),
        );
    }
}
