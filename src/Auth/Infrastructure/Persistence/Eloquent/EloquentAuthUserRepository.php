<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Persistence\Eloquent;

use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserToken;
use Src\Auth\Domain\Exception\AuthUserNotFoundException;
use Src\Auth\Domain\Exception\InvalidAuthUserEmailException;
use Src\Auth\Domain\Exception\UniqueAuthUserEmailException;
use Src\Auth\Domain\Repository\AuthUserRepository;

class EloquentAuthUserRepository implements AuthUserRepository
{
    public function findByEmail(AuthUserEmail $email): AuthUser
    {
        $model = EloquentAuthUserModel::query()
            ->where('email', $email->value())
            ->first();
        if (!$model) {
            throw new InvalidAuthUserEmailException();
        }

        return $this->createDomainEntityFromEloquentModel($model);
    }


    public function create(AuthUserName $name, AuthUserEmail $email, AuthUserPassword $password): AuthUser
    {
        if (EloquentAuthUserModel::query()->where('email', $email->value())->exists()) {
            throw new UniqueAuthUserEmailException();
        }
        $model = EloquentAuthUserModel::query()
            ->create([
                'name' => $name->value(),
                'email' => $email->value(),
                'password' => $password->value(),
            ]);

        return $this->createDomainEntityFromEloquentModel($model);
    }


    public function findById(AuthUserId $id): AuthUser
    {
        $model = EloquentAuthUserModel::query()
            ->find($id->value());
        if (!$model) {
            throw new AuthUserNotFoundException();
        }

        return $this->createDomainEntityFromEloquentModel($model);
    }


    private function createDomainEntityFromEloquentModel(EloquentAuthUserModel $model): AuthUser
    {
        return AuthUser::create(
            new AuthUserId($model->id),
            new AuthUserName($model->name),
            new AuthUserEmail($model->email),
            new AuthUserPassword($model->password)
        );
    }
}
