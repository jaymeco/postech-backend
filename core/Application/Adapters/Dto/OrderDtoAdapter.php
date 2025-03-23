<?php

namespace Core\Application\Adapters\Dto;

use Core\Application\Dtos\Order\OrderDto;
use Core\Domain\Entities\Order;

abstract class OrderDtoAdapter
{
    public static function parse(Order $order)
    {
        return new OrderDto(
            $order->getUuid()->getValue(),
            $order->getCode()->getValue(),
            $order->getPrice()->getValue(),
            CommonDtoAdapter::parse($order->getStatus()),
            self::parseProducts($order->getProducts()),
        );
    }

    private static function parseProducts(array $products)
    {
        return array_map(fn($data) => ProductDtoAdapter::parse($data), $products);
    }
}
