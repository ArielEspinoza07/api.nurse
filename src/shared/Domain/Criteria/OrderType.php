<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

use Src\shared\Domain\Validation\AssertIsBetweenAcceptedValues;

class OrderType
{
    use AssertIsBetweenAcceptedValues;

    public const ASC = 'asc';
    public const DESC = 'desc';
    public const NONE = '';

    private function __construct(private readonly string $value)
    {
        $this->assertIsBetweenAcceptedValues($this->value, [self::ASC, self::DESC, self::NONE]);
    }

    public static function create(string $value): self
    {
        return new static($value);
    }

    public static function createDesc(): self
    {
        return new static(OrderType::DESC);
    }

    public static function createNone(): self
    {
        return new static(OrderType::NONE);
    }

    public function isNone(): bool
    {
        return $this->value === self::NONE;
    }

    public function value(): string
    {
        return $this->value;
    }
}
