<?php

declare(strict_types=1);

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
                OrderBy::create($order['by']),
                OrderType::create($order['type'])
            );
        }
        if (is_string($order)) {
            return Order::createDesc(OrderBy::create($order));
        }

        return Order::createEmpty();
    }
}
