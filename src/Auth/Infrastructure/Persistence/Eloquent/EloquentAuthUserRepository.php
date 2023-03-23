<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Persistence\Eloquent;

use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserEmailVerify;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\Exception\AuthUserNotFoundException;
use Src\Auth\Domain\Exception\InvalidAuthUserEmailException;
use Src\Auth\Domain\Exception\UniqueAuthUserEmailException;
use Src\Auth\Domain\Repository\AuthUserRepository;

class EloquentAuthUserRepository implements AuthUserRepository
{
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

        return AuthUser::create(
            AuthUserId::create($model->id),
            $name,
            $email,
            $password
        );
    }


    public function findById(AuthUserId $id): AuthUser
    {
        $model = EloquentAuthUserModel::query()
            ->find($id->value());
        if (!$model) {
            throw new AuthUserNotFoundException();
        }

        return AuthUser::create(
            $id,
            AuthUserName::create($model->name),
            AuthUserEmail::create($model->email, AuthUserEmailVerify::create($model->hasVerifiedEmail())),
            AuthUserPassword::create($model->password)
        );
    }

    public function findByEmail(AuthUserEmail $email): AuthUser
    {
        $model = EloquentAuthUserModel::query()
            ->where('email', $email->value())
            ->first();
        if (!$model) {
            throw new InvalidAuthUserEmailException();
        }
        $email->setEmailVerify(AuthUserEmailVerify::create($model->hasVerifiedEmail()));

        return AuthUser::create(
            AuthUserId::create($model->id),
            AuthUserName::create($model->name),
            $email,
            AuthUserPassword::create($model->password)
        );
    }

    public function verifyEmail(AuthUser $user): void
    {
        EloquentAuthUserModel::query()->where([
            'id' => $user->id()->value(),
            'email' => $user->email()->value(),
        ])->update(['email_verified_at' => now()]);
    }
}
