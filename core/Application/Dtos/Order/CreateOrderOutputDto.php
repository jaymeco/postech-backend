<?php

namespace Core\Application\Dtos\Order;

class CreateOrderOutputDto
{
    public function __construct(
        public readonly OrderDto $order,
        public readonly ?string $code = null,
        public readonly ?string $access_token = null,
    ) {}
}
