<?php

namespace Core\Domain\Entities;

use Carbon\Carbon;
use Core\Domain\Base\Enums\OrderStatusEnum;
use Core\Domain\ValueObjects\OrderCode;
use Core\Domain\ValueObjects\Price;
use Core\Domain\ValueObjects\Uuid;
use DateTimeInterface;

class Order
{
    /*** @var Product[] */
    private array $products = [];

    private function __construct(
        private Uuid $uuid,
        private Uuid $customerUuid,
        private OrderStatus $status,
        private OrderCode $code,
        private DateTimeInterface $orderedAt,
        private Price $price,
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
            Price::create(0)
        );
    }

    public static function restore(
        string $uuid,
        string $customerUuid,
        string $code,
        OrderStatus $status,
        string $orderedAt,
        float $price,
    ) {
        return new static(
            Uuid::create($uuid),
            Uuid::create($customerUuid),
            $status,
            OrderCode::create($code),
            Carbon::parse($orderedAt),
            Price::create($price)
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

    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        $this->price->sum($product->getPrice()->getValue());
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function defineReady()
    {
        $enum = OrderStatusEnum::READY;
        $this->status = OrderStatus::restore(
            $enum->key(),
            $enum->name(),
        );
    }
}
