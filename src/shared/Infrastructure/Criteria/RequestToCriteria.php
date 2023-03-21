<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Criteria;

use Src\shared\Domain\Criteria\Criteria;

class RequestToCriteria
{
    private function __construct(
        private readonly string|null $filters,
        private readonly array|string|null $order,
        private readonly string|null $page,
        private readonly string|null $limit
    ) {
    }

    public static function create(
        string|null $filters,
        array|string|null $order,
        string|null $page,
        string|null $limit
    ): self {
        return new static($filters, $order, $page, $limit);
    }

    public function convert(): Criteria
    {
        if (is_null($this->page) && is_null($this->limit)) {
            return Criteria::createWithoutPagination(
                StringToFilters::create($this->filters)->convert(),
                (new OrderBuilder())->build($this->order)
            );
        }

        return Criteria::create(
            StringToFilters::create($this->filters)->convert(),
            (new OrderBuilder())->build($this->order),
            intval($this->page) ?? Criteria::PAGE,
            intval($this->limit) ?? Criteria::LIMIT,
        );
    }
}
