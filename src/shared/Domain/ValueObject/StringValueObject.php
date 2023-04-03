<?php

declare(strict_types=1);

namespace Src\shared\Domain\ValueObject;

abstract class StringValueObject
{
    protected function __construct(protected readonly string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }
}
