<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Criteria;

use Src\shared\Domain\Criteria\Order;

class OrderBuilder
{
    public function build(array|string|null $order): Order
    {
        if (is_array($order)) {
            return ArrayToOrder::create($order)->convert();
        }
        if (is_string($order)) {
            return StringToOrder::create($order)->convert();
        }

        return Order::createEmpty();
    }
}
