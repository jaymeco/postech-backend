<?php

namespace Core\Application\Dtos;

class PaymentRequest
{
    public function __construct(
        public readonly string $code,
        public readonly float $amount,
        public readonly string $notificationUrl,
    ) {}
}
