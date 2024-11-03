<?php

namespace Core\Application\Contracts\Services;

use Core\Domain\Entities\Order;

interface OrderService
{
    public function getByUuid(string $uuid): Order;

    /***@return Order[] */
    public function getAll(): array;
}
