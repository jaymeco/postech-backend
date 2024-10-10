<?php

namespace Core\Application\Contracts\Repositories;

use Core\Domain\Entities\Order;

interface OrderRepository
{
    public function save(Order $order): void;
}
