<?php

namespace Core\Application\UseCases\Order;

use Core\Application\Adapters\Dto\OrderDtoAdapter;
use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Dtos\Order\OrderDto;

class GetAllOrdersUseCase
{
    public function __construct(
        private readonly OrderRepository $respository
    ) {}

    /**
     * @return OrderDto[]
     */
    public function execute(): array
    {
        $orders = $this->respository->all();

        return array_map(fn($order) => OrderDtoAdapter::parse($order), $orders);
    }
}
