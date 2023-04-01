<?php

declare(strict_types=1);

namespace Src\Auth\Application;

class AuthUserResponse
{
    public function __construct(private readonly int $id, private readonly string $token)
    {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->id . '|' . $this->token
        ];
    }
}
