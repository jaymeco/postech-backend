<?php

namespace Core\Application\UseCases\Order;

use Core\Application\Adapters\Dto\OrderDtoAdapter;
use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Dtos\Order\OrderDto;
use Core\Application\Exceptions\InvalidStatusToUpdateException;
use Core\Domain\Base\Enums\OrderStatusEnum;
use Core\Domain\Entities\Order;
use Illuminate\Support\Facades\DB;

class FinishOrderUseCase
{
    public function __construct(
        private readonly OrderRepository $repository,
    ) {}

    public function execute(string $orderUuid): OrderDto
    {
        try {
            DB::beginTransaction();
            $order = $this->repository->getByUuid($orderUuid);

            $this->throwErrorIfOrderIsNotReady($order);

            $order->finish();

            $this->repository->update($order);

            $data = OrderDtoAdapter::parse($order);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $data;
    }

    private function throwErrorIfOrderIsNotReady(Order $order)
    {
        if (!$order->getStatus()->getUuid()->equals(OrderStatusEnum::READY->key())) {
            InvalidStatusToUpdateException::throw();
        }
    }
}
