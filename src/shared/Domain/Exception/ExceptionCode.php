<?php

declare(strict_types=1);

namespace Src\shared\Domain\Exception;

use Src\shared\Domain\Validation\Contract\AssertNotNullable;
use Src\shared\Domain\ValueObject\IntValueObject;

class ExceptionCode extends IntValueObject
{
    use AssertNotNullable;

    private function __construct(protected int $value)
    {
        parent::__construct($this->value);
        $this->assertNotNull($this->value);
    }

    public static function create(int $value): self
    {
        return new static($value);
    }
}
