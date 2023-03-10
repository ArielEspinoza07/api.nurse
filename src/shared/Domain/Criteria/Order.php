<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

class Order
{
    public function __construct(
        private readonly OrderBy $orderBy,
        private readonly OrderType $orderType,
    ) {
    }

    public static function create(OrderBy $orderBy, OrderType $orderType): self
    {
        return new static($orderBy, $orderType);
    }

    public static function createDesc(OrderBy $orderBy): self
    {
        return new static($orderBy, new OrderType(OrderType::DESC));
    }

    public static function none(): self
    {
        return new static(new OrderBy(''), new OrderType(OrderType::NONE));
    }

    public function getOrderBy(): OrderBy
    {
        return $this->orderBy;
    }

    public function getOrderType(): OrderType
    {
        return $this->orderType;
    }
}
