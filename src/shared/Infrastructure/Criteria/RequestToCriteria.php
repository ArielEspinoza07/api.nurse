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
                (new GetOrder())->handle($this->order)
            );
        }

        return Criteria::create(
            StringToFilters::create($this->filters)->convert(),
            (new GetOrder())->handle($this->order),
            intval($this->page) ?? Criteria::PAGE,
            intval($this->limit) ?? Criteria::LIMIT,
        );
    }
}
