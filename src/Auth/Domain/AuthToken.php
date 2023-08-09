<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

class AuthToken
{
    protected function __construct(
        protected readonly AuthTokenId $id,
        protected AuthPlainTextToken $plainTextToken,
        protected AuthUser $user
    ) {
    }

    public static function create(AuthTokenId $id, AuthPlainTextToken $plainTextToken, AuthUser $user): self
    {
        return new static($id, $plainTextToken, $user);
    }

    public function id(): AuthTokenId
    {
        return $this->id;
    }

    public function plainText(): AuthPlainTextToken
    {
        return $this->plainTextToken;
    }

    public function user(): AuthUser
    {
        return $this->user;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->id->value() . '|' . $this->plainTextToken->value(),
            'user' => $this->user->toArray(),
        ];
    }
}
