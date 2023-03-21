<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Token;

use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserToken;
use Src\Auth\Domain\Token\TokenCreatorContract;
use Src\Auth\Domain\Token\TokenDeletorContract;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthUserModel;

class LaravelSanctumToken implements TokenCreatorContract, TokenDeletorContract
{
    public function create(AuthUser $user): AuthUserToken
    {
        $model = EloquentAuthUserModel::query()
            ->find(
                $user->id()
                    ->value()
            );

        if (!$model->wasRecentlyCreated) {
            $model->currentAccessToken()
                ->delete();
        }

        return AuthUserToken::create($model->createPlainTextToken());
    }


    public function delete(AuthUser $user): void
    {
        EloquentAuthUserModel::query()
            ->find(
                $user->id()
                    ->value()
            )
            ->tokens()
            ->delete();
    }
}
