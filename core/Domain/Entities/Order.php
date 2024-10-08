<?php

namespace Core\Domain\Entities;

use Core\Domain\Base\Enums\OrderStatusEnum;
use Core\Domain\ValueObjects\OrderCode;
use Core\Domain\ValueObjects\Uuid;
use DateTimeInterface;

class Order
{
    private function __construct(
        private Uuid $uuid,
        private Uuid $customerUuid,
        private OrderStatus $status,
        private OrderCode $code,
        private DateTimeInterface $orderedAt
    ) {}

    public static function create(string $customerUuid)
    {
        $enum = OrderStatusEnum::CREATED;
        $status = OrderStatus::restore($enum->key(), $enum->name());

        return new static(
            Uuid::create(),
            Uuid::create($customerUuid),
            $status,
            OrderCode::generate(),
            now(),
        );
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getCustomerUuid()
    {
        return $this->customerUuid;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getOrderedAt()
    {
        return $this->orderedAt;
    }
}
