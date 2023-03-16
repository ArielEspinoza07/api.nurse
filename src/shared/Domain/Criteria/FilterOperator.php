<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

use Src\shared\Domain\Validation\Contract\AssertIsBetweenAcceptedValues;

class FilterOperator
{
    use AssertIsBetweenAcceptedValues;

    public const CONTAINS = 'CONTAINS';
    public const EQUAL = '=';
    public const GREATER_THAN = '>';
    public const LIKE = 'like';
    public const NOT_CONTAINS = 'NOT_CONTAINS';
    public const NOT_EQUAL = '<>';
    public const SMALLER_THAN = '<';

    public function __construct(private readonly string $value)
    {
        $this->assertIsBetweenAcceptedValues(
            $this->value,
            [
                self::CONTAINS,
                self::EQUAL,
                self::GREATER_THAN,
                self::LIKE,
                self::NOT_CONTAINS,
                self::NOT_EQUAL,
                self::SMALLER_THAN
            ]
        );
    }

    public function value(): string
    {
        return $this->value;
    }
}
