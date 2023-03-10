<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

use Src\shared\Domain\Validation\Contract\AssertIsBetweenAcceptedValues;

class OrderType
{
    use AssertIsBetweenAcceptedValues;

    public const ASC = 'asc';
    public const DESC = 'desc';
    public const NONE = '';

    public function __construct(private readonly string $value)
    {
        $this->assertIsBetweenAcceptedValues($this->value, [self::ASC, self::DESC, self::NONE]);
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
