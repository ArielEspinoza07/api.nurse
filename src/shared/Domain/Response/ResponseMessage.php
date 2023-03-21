<?php

declare(strict_types=1);

namespace Src\shared\Domain\Response;

use Src\shared\Domain\Validation\Contract\AssertNotNullable;
use Src\shared\Domain\ValueObject\StringValueObject;

class ResponseMessage extends StringValueObject
{
    use AssertNotNullable;

    private function __construct(protected string $value)
    {
        parent::__construct($this->value);
        $this->assertNotNull($this->value);
    }

    public static function create(string $value): self
    {
        return new static($value);
    }
}
