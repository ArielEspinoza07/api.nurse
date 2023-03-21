<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

use Src\shared\Domain\Validation\Contract\AssertIsBetweenAcceptedValues;
use Src\shared\Domain\ValueObject\StringValueObject;

class FilterOperator extends StringValueObject
{
    use AssertIsBetweenAcceptedValues;

    public const CONTAINS = 'CONTAINS';
    public const EQUAL = '=';
    public const GREATER_THAN = '>';
    public const LIKE = 'like';
    public const NOT_CONTAINS = 'NOT_CONTAINS';
    public const NOT_EQUAL = '<>';
    public const SMALLER_THAN = '<';

    protected function __construct(protected string $value)
    {
        parent::__construct($this->value);
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

    public static function create(string $value): self
    {
        return new static($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
