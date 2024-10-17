<?php

namespace Core\Application\Contracts\Repositories;

use Core\Domain\Entities\Order;

interface OrderRepository
{
    public function save(Order $order): void;

    public function getByUuid(string $uuid): Order;

    public function update(Order $order): void;
}
