<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

class Order
{
    private function __construct(
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
        return new static($orderBy, OrderType::createDesc());
    }

    public static function createEmpty(): self
    {
        return new static(OrderBy::createEmpty(), OrderType::createNone());
    }

    public function orderBy(): OrderBy
    {
        return $this->orderBy;
    }

    public function orderType(): OrderType
    {
        return $this->orderType;
    }
}
