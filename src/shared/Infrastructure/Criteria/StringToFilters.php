<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Criteria;

use Src\shared\Domain\Criteria\Filter;
use Src\shared\Domain\Criteria\FilterField;
use Src\shared\Domain\Criteria\FilterOperator;
use Src\shared\Domain\Criteria\Filters;
use Src\shared\Domain\Criteria\FilterValue;

class StringToFilters
{
    private function __construct(private readonly string $filters)
    {
    }

    public static function create(string $filters = ''): self
    {
        return new static($filters);
    }
    public function convert(): Filters
    {
        $criteriaFilters = Filters::create();
        if (!empty($this->filters)) {
            foreach (explode(',', $this->filters) as $filter) {
                list($field, $operator, $value) = explode(':', $filter);
                $criteriaFilters->add(
                    Filter::create(
                        FilterField::create($field),
                        FilterOperator::create($operator),
                        FilterValue::create($value),
                    )
                );
            }
        }

        return $criteriaFilters;
    }
}
