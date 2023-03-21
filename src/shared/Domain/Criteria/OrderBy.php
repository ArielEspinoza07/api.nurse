<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

use Src\shared\Domain\ValueObject\StringValueObject;

class OrderBy extends StringValueObject
{
    private function __construct(protected string $value)
    {
        parent::__construct($this->value);
    }

    public static function create(string $value): self
    {
        return new static($value);
    }

    public static function createEmpty(): self
    {
        return new static('');
    }
}
