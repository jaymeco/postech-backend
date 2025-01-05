<?php

namespace Core\Application\UseCases\Order;

use Core\Application\Adapters\Dto\OrderDtoAdapter;
use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Dtos\Order\OrderDto;

class GetOrderByUuidUseCase
{
    public function __construct(
        private readonly OrderRepository $repository,
    ) {}

    public function execute(string $orderUuid): OrderDto
    {
        $order = $this->repository->getByUuid($orderUuid);

        return OrderDtoAdapter::parse($order);
    }
}
