<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

use Src\shared\Domain\Validation\Contract\AssertNotNullable;
use Src\shared\Domain\ValueObject\IntValueObject;

class AuthUserId extends IntValueObject
{
    use AssertNotNullable;

    protected function __construct(protected int $value)
    {
        parent::__construct($this->value);

        $this->assertNotNull($this->value);
    }

    public static function create(int $value): self
    {
        return new static($value);
    }
}
