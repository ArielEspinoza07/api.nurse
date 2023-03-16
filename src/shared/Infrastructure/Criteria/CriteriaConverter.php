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

    public function convert(): Criteria|null
    {
        if (!empty($this->inputDTO->filters) || !empty($this->inputDTO->order) || !empty($this->inputDTO->limit)) {
            return new Criteria(
                (new GetFilters())->handle($this->inputDTO->filters),
                (new GetOrder())->handle($this->inputDTO->order),
                $this->inputDTO->page,
                $this->inputDTO->limit
            );
        }

        return null;
    }
}
