<?php

namespace Core\Application\Services;

use Core\Application\Contracts\Repositories\CustomerRepository;
use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Contracts\Services\OrderService as Contract;
use Core\Domain\Entities\Customer;
use Core\Domain\Entities\Order;

class OrderService implements Contract
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
    ) {}

    public function getByUuid(string $uuid): Order
    {
        return $this->orderRepository->getByUuid($uuid);
    }

    public function getAll(): array
    {
        return $this->orderRepository->all();
    }
}
