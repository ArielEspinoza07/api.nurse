<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Persistence\Eloquent\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Src\shared\Domain\Criteria\Filter;
use Src\shared\Domain\Criteria\FilterOperator;

class FilterToQuery
{
    private function __construct(
        private readonly Builder $query,
        private readonly Filter $filter,
        private readonly bool $and
    ) {
    }

    public static function create(Builder $query, Filter $filter, bool $and): self
    {
        return new static($query, $filter, $and);
    }

    public static function createFromQueryAndFilter(Builder $query, Filter $filter): self
    {
        return new static($query, $filter, false);
    }

    public function convert(): void
    {
        if ($this->and) {
            if ($this->filter->operator()->value() === FilterOperator::LIKE) {
                $this->query->where(
                    $this->filter->field()->value(),
                    $this->filter->operator()->value(),
                    "%{$this->filter->value()->value()}%"
                );

                return;
            }
            $this->query->where(
                $this->filter->field()->value(),
                $this->filter->operator()->value(),
                $this->filter->value()->value()
            );

            return;
        }
        if ($this->filter->operator()->value() === FilterOperator::LIKE) {
            $this->query->orWhere(
                $this->filter->field()->value(),
                $this->filter->operator()->value(),
                "%{$this->filter->value()->value()}%"
            );

            return;
        }
        $this->query->orWhere(
            $this->filter->field()->value(),
            $this->filter->operator()->value(),
            $this->filter->value()->value()
        );
    }
}
