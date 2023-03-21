<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Criteria;

use Src\shared\Domain\Criteria\Order;
use Src\shared\Domain\Criteria\OrderBy;
use Src\shared\Domain\Criteria\OrderType;

class ArrayToOrder
{
    private function __construct(private readonly array $order)
    {
    }

    public static function create(array $order): self
    {
        return new static($order);
    }

    public function convert(): Order
    {
        return Order::create(
            OrderBy::create($this->order['by']),
            OrderType::create($this->order['type'])
        );
    }
}
