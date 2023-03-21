<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

class Criteria
{
    public const LIMIT = 15;
    public const PAGE = 1;

    private function __construct(
        private readonly Filters $filters,
        private readonly Order $order,
        private readonly int $page = 1,
        private readonly int $limit = 15
    ) {
    }

    public static function create(Filters $filters, Order $order, int $page, int $limit): self
    {
        return new static($filters, $order, $page, $limit);
    }

    public static function createWithoutPagination(Filters $filters, Order $order): self
    {
        return new static($filters, $order, 0, 0);
    }

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function hasFilters(): bool
    {
        return $this->filters->count() > 0;
    }

    public function isWithoutPagination(): bool
    {
        return $this->page === 0 && $this->limit === 0;
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

    public function toArray(): array
    {
        return array_merge(
            $this->filters->toArray(),
            $this->order->toArray(),
            [
                'page' => $this->page,
                'limit' => $this->limit,
            ]
        );
    }
}
