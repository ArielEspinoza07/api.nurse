<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

class Filter
{
    public function __construct(
        private readonly FilterField $field,
        private readonly FilterOperator $operator,
        private readonly FilterValue $value
    ) {
    }

    public static function createFromValues(FilterField $field, FilterOperator $operator, FilterValue $value): self
    {
        return new static($field, $operator, $value);
    }

    public static function createFromFieldAndValue(FilterField $field, FilterValue $value): self
    {
        return new static(
            $field,
            new FilterOperator(FilterOperator::EQUAL),
            $value
        );
    }

    public function field(): FilterField
    {
        return $this->field;
    }

    public function operator(): FilterOperator
    {
        return $this->operator;
    }

    public function value(): FilterValue
    {
        return $this->value;
    }


}
