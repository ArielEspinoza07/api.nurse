<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Criteria;

use Src\shared\Domain\Criteria\Filter;
use Src\shared\Domain\Criteria\FilterField;
use Src\shared\Domain\Criteria\FilterOperator;
use Src\shared\Domain\Criteria\Filters;
use Src\shared\Domain\Criteria\FilterValue;

class GetFilters
{
    public function handle(string|null $filters): Filters
    {
        $criteriaFilters = Filters::create();
        if (!empty($filters)) {
            foreach (explode(',', $filters) as $filter) {
                list($field, $operator, $value) = explode(':', $filter);
                $criteriaFilters->add(
                    new Filter(
                        new FilterField($field),
                        new FilterOperator($operator),
                        new FilterValue($value),
                    )
                );
            }
        }

        return $criteriaFilters;
    }
}
