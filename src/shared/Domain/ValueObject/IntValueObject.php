<?php

declare(strict_types=1);

namespace Src\shared\Domain\ValueObject;

abstract class IntValueObject
{
    public function __construct(protected int $value)
    {
    }

    public static function none(): self
    {
        return new static(0);
    }

    public static function random(): self
    {
        return new static(random_int(1, 256));
    }

    public function value(): int
    {
        return $this->value;
    }
}
