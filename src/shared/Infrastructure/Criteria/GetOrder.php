<?php

namespace Src\shared\Infrastructure\Criteria;

use Src\shared\Domain\Criteria\Order;
use Src\shared\Domain\Criteria\OrderBy;
use Src\shared\Domain\Criteria\OrderType;

class GetOrder
{
    public function handle(array|string|null $order): Order
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
