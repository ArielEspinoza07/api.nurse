<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Token;

use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserToken;
use Src\Auth\Domain\Contracts\TokenCreatorInterface;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthUserModel;

class LaravelSanctumTokenCreator implements TokenCreatorInterface
{

    public function create(AuthUser $user): AuthUserToken
    {
        $model = EloquentAuthUserModel::query()
            ->find($user->id()->value());

        if (!$model->wasRecentlyCreated) {
            $model->currentAccessToken()
                ->delete();
        }

        return new AuthUserToken($model->createPlainTextToken());
    }
}
