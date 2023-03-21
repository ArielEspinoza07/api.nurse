<?php

declare(strict_types=1);

namespace Src\shared\Domain\ValueObject;

abstract class IntValueObject
{
    protected function __construct(protected int $value)
    {
    }

    public static function createEmpty(): static
    {
        return new static(0);
    }

    public static function random(): static
    {
        return new static(random_int(1, 256));
    }

    public function value(): int
    {
        return $this->value;
    }
}
