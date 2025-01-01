<?php

namespace Core\Application\Dtos;

class PaymentData
{
    public function __construct(
        public readonly string $status,
        public readonly string $date,
    ) {}

    public function isApproved()
    {
        return $this->status == 'approved';
    }

    public function isRejected()
    {
        return $this->status == 'rejected';
    }

    public function isCancelled()
    {
        return $this->status == 'cancelled';
    }
}
