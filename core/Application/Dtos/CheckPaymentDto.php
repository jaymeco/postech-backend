<?php

namespace Core\Application\Dtos;

class CheckPaymentDto
{
    public function __construct(
        public readonly string $status,
        public readonly string $order_code,
        public readonly ?string $payment_date = null,
    ) {}
}
