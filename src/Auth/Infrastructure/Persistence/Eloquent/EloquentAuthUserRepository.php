<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Persistence\Eloquent;

use Src\Auth\Domain\AuthUserEmail;
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
        if (EloquentAuthUserModel::query()->where('email', $email->emailAddress()->value())->exists()) {
            throw new UniqueAuthUserEmailException();
        }
        $model = EloquentAuthUserModel::query()
            ->create([
                'name' => $name->value(),
                'email' => $email->emailAddress()->value(),
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

        return AuthUser::fromPrimitives(
            $id->value(),
            $model->name,
            $model->email,
            $model->hasVerifiedEmail(),
            $model->password
        );
    }

    public function findByEmail(AuthUserEmail $authUserEmail): AuthUser
    {
        $model = EloquentAuthUserModel::query()
            ->where('email', $authUserEmail->emailAddress()->value())
            ->first();
        if (!$model) {
            throw new InvalidAuthUserEmailException();
        }

        return AuthUser::fromPrimitives(
            $model->id,
            $model->name,
            $authUserEmail->emailAddress()->value(),
            $model->hasVerifiedEmail(),
            $model->password
        );
    }

    public function verifyEmail(AuthUser $user): void
    {
        EloquentAuthUserModel::query()->where([
            'id' => $user->id()->value(),
            'email' => $user->email()->emailAddress()->value(),
        ])->update(['email_verified_at' => now()]);
    }
}
