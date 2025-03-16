<?php

namespace Core\Application\Dtos\Order;

use Core\Application\Dtos\CommonDto;

class OrderDto
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $code,
        public readonly float $price,
        public readonly CommonDto $status,
        public readonly array $products,
    ) {
    }
}
