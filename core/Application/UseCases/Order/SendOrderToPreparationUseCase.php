<?php

namespace Core\Application\UseCases\Order;

use Core\Application\Adapters\Dto\OrderDtoAdapter;
use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Dtos\Order\OrderDto;
use Core\Application\Exceptions\InvalidStatusToUpdateException;
use Core\Domain\Base\Enums\OrderStatusEnum;
use Core\Domain\Entities\Order;

class SendOrderToPreparationUseCase
{
    public function __construct(
        private readonly OrderRepository $repository,
    ) {}

    public function execute(string $orderUuid): OrderDto
    {
        $order = $this->repository->getByUuid($orderUuid);

        $this->throwErrorIfOrderIsNotReceived($order);

        $order->setAsPreparing();

        $this->repository->update($order);

        return OrderDtoAdapter::parse($order);
    }

    private function throwErrorIfOrderIsNotReceived(Order $order)
    {
        if (!$order->getStatus()->getUuid()->equals(OrderStatusEnum::RECEIVED->key())) {
            InvalidStatusToUpdateException::throw();
        }
    }
}
