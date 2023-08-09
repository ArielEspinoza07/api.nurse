<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

use Src\shared\Domain\Validation\AssertNotNullable;
use Src\shared\Domain\ValueObject\StringValueObject;

class AuthUserName extends StringValueObject
{
    use AssertNotNullable;

    protected function __construct(protected string $value)
    {
        parent::__construct($this->value);

        $this->assertNotNull($this->value);
    }

    public static function create(string $value): self
    {
        return new static($value);
    }
}
