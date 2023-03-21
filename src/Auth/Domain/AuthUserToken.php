<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

use Src\shared\Domain\Validation\Contract\AssertValueLength;
use Src\shared\Domain\ValueObject\StringValueObject;

class AuthUserToken extends StringValueObject
{
    use AssertValueLength;

    public const TOKEN_LENGTH = 42;

    private function __construct(protected string $value)
    {
        parent::__construct($this->value);

        $this->assertValueLength($this->value, self::TOKEN_LENGTH);
    }

    public static function create(string $value): self
    {
        return new static($value);
    }

    public function toArray(): array
    {
        return [
            'token' => $this->value,
        ];
    }
}
