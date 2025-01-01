<?php

namespace Core\Application\Contracts\Repositories;

use Core\Domain\Entities\Payment;

interface PaymentRepository
{
    public function getActiveByOrderUuid(string $orderUuid): Payment|null;

    public function create(Payment $payment): void;

    public function update(Payment $payment): void;
}
