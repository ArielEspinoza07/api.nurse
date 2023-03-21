<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Criteria;

use Src\shared\Domain\Criteria\Order;
use Src\shared\Domain\Criteria\OrderBy;

class StringToOrder
{
    private function __construct(private readonly string $order)
    {
    }

    public static function create(string $order = ''): self
    {
        return new static($order);
    }

    public function convert(): Order
    {
        return Order::createDesc(OrderBy::create($this->order));
    }
}
