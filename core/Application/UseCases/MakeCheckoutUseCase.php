<?php

namespace Core\Application\UseCases;

use Core\Application\Contracts\Repositories\OrderRepository;

class MakeCheckoutUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
    ) {}

    public function execute(string $orderUuid)
    {
        $order = $this->orderRepository->getByUuid($orderUuid);

        $order->defineReady();

        $this->orderRepository->update($order);
    }
}
