<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

use Src\shared\Domain\Validation\AssertNotNullable;

class AuthUserEmailVerify
{
    use AssertNotNullable;

    private function __construct(private readonly bool $value)
    {
        $this->assertNotNull($this->value);
    }

    public static function create(bool $value): self
    {
        return new static($value);
    }

    public static function createNotVerified(): self
    {
        return new static(false);
    }

    public function isVerified(): bool
    {
        return $this->value === true;
    }

    public function value(): bool
    {
        return $this->value;
    }
}
