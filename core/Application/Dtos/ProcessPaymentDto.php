<?php

namespace Core\Application\Dtos;

class ProcessPaymentDto
{
    public function __construct(
        public readonly string $paymentId,
    ) {}
}
