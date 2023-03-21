<?php

declare(strict_types=1);

namespace Src\shared\Domain\Exception;

class ExceptionData
{
    private function __construct(private readonly array|null $value)
    {
    }

    public static function create(array $value): self
    {
        return new static($value);
    }

    public static function empty(): self
    {
        return new static(null);
    }

    public function value(): array|null
    {
        return $this->value;
    }
}
