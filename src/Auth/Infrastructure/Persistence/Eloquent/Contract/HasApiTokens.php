<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Persistence\Eloquent\Contract;


use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Sanctum\HasApiTokens as SanctumApiTokens;
use Src\Auth\Infrastructure\Persistence\Eloquent\EloquentAuthTokenModel;

trait HasApiTokens
{
    use SanctumApiTokens;

    public function createPlainTextToken(): string
    {
        return $this->createToken(strval($this->id))->plainTextToken;
    }

    public function currentAccessToken(): MorphMany
    {
        return $this->morphMany(EloquentAuthTokenModel::class, 'tokenable');
    }
}
