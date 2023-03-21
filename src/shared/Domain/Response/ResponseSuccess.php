<?php

declare(strict_types=1);

namespace Src\shared\Domain\Response;

class ResponseSuccess
{
    private function __construct(private readonly bool $values)
    {
    }

    public static function create(bool $value): self
    {
        return new static($value);
    }

    public function value(): bool
    {
        return $this->values;
    }
}
