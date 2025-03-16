<?php

namespace Core\Application\Dtos;

class QrPaymentData
{
    public function __construct(
        public readonly string $qrCode,
    ) {}
}
