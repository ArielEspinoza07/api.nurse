<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Persistence\Eloquent;

use Illuminate\Support\Str;
use Src\Auth\Domain\AuthPlainTextToken;
use Src\Auth\Domain\AuthToken;
use Src\Auth\Domain\AuthTokenId;
use Src\Auth\Domain\AuthUser;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\Repository\AuthTokenRepository;

class EloquentAuthTokenRepository implements AuthTokenRepository
{
    public function create(AuthUser $user): AuthToken
    {
        $query = EloquentAuthTokenModel::query()
            ->where([
                'tokenable_type' => EloquentAuthUserModel::class,
                'tokenable_id' => $user->id()->value(),
                'name' => $user->id()->value(),
            ]);
        if ($query->exists()) {
            $query->delete();
        }

        $eloquentAuthToken = EloquentAuthTokenModel::query()
            ->create([
                'tokenable_type' => EloquentAuthUserModel::class,
                'tokenable_id' => $user->id()->value(),
                'name' => $user->id()->value(),
                'token' => hash('sha256', $plainTextToken = Str::random(40)),
                'expires_at' => now()->endOfDay(),
            ]);

        return AuthToken::create(
            AuthTokenId::create($eloquentAuthToken->id),
            AuthPlainTextToken::create($plainTextToken),
            $user
        );
    }

    public function delete(AuthToken $token): void
    {
        EloquentAuthTokenModel::query()
            ->where('id', $token->id()->value())
            ->delete();
    }

    public function findByUserId(AuthUserId $id): AuthToken
    {
        $authToken = EloquentAuthTokenModel::query()
            ->with('tokenable')
            ->where([
                'tokenable_type' => EloquentAuthUserModel::class,
                'tokenable_id' => $id->value(),
                'name' => $id->value(),
            ])->first();

        return AuthToken::create(
            AuthTokenId::create($authToken->id),
            AuthPlainTextToken::create($authToken->token),
            AuthUser::createFromPrimitives(
                $authToken->tokenable->id,
                $authToken->tokenable->name,
                $authToken->tokenable->email,
                $authToken->tokenable->hasVerifiedEmail(),
                $authToken->tokenable->password,
            )
        );
    }
}
