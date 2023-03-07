<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Criteria;

use Src\shared\Domain\Criteria\Criteria;
use Src\shared\Domain\Criteria\Filter;
use Src\shared\Domain\Criteria\FilterField;
use Src\shared\Domain\Criteria\FilterOperator;
use Src\shared\Domain\Criteria\Filters;
use Src\shared\Domain\Criteria\FilterValue;
use Src\shared\Domain\Criteria\Order;
use Src\shared\Domain\Criteria\OrderBy;
use Src\shared\Domain\Criteria\OrderType;
use Src\shared\Infrastructure\Criteria\DTO\SearchByCriteriaInputDTO;

class CriteriaConverter
{

    public function __construct(private readonly SearchByCriteriaInputDTO $inputDTO)
    {
    }

    public function converter(): Criteria|null
    {
        if (!empty($this->inputDTO->filters) || !empty($this->inputDTO->order) || !empty($this->inputDTO->limit)) {
            return new Criteria(
                $this->filters($this->inputDTO->filters),
                $this->order($this->inputDTO->order),
                $this->inputDTO->page ?? 1,
                $this->inputDTO->limit ?? 15
            );
        }

        return null;
    }

    private function filters(string $filters): Filters
    {
        $criteriaFilters = new Filters([]);
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

    private function order(array|string $order): Order
    {
        if (is_array($order)) {
            return Order::create(
                new OrderBy($order['by']),
                new OrderType($order['type'])
            );
        }
        if (is_string($order)) {
            return Order::createDesc(new OrderBy($order));
        }

        return Order::none();
    }
}
