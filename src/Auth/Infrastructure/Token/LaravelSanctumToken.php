<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Token;

use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserToken;
use Src\Auth\Domain\Contracts\TokenCreatorInterface;
use Src\Auth\Domain\Contracts\TokenDeletorInterface;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthUserModel;

class LaravelSanctumToken implements TokenCreatorInterface, TokenDeletorInterface
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
