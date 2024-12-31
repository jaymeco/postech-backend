<?php

namespace Core\Application\Contracts\Services;

use Core\Application\Dtos\PaymentData;
use Core\Application\Dtos\PaymentRequest;
use Core\Application\Dtos\QrPaymentData;

interface PaymentService
{
    public function requestQrCode(PaymentRequest $request): QrPaymentData;

    public function findPaymentById(string $id): PaymentData;
}
