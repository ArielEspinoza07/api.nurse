<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

class Criteria
{
    public function __construct(
        private readonly Filters $filters,
        private readonly Order $order,
        private readonly int $page,
        private readonly int $limit
    ) {
    }

    public static function create(Filters $filters, Order $order, int $page = 1, int $limit = 15): self
    {
        return new static($filters, $order, $page, $limit);
    }

    public function hasFilters(): bool
    {
        return $this->filters->count() > 0;
    }

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function order(): Order
    {
        return $this->order;
    }

    public function page(): int
    {
        return $this->page;
    }
}
