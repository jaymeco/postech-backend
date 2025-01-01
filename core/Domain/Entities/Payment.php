<?php

namespace Core\Domain\Entities;

use Carbon\Carbon;
use Core\Domain\Base\Enums\PaymentStatus;
use Core\Domain\ValueObjects\CommonId;
use Core\Domain\ValueObjects\Uuid;
use DateTimeInterface;

class Payment
{
    public function __construct(
        private Uuid $orderUuid,
        private CommonId $paymentId,
        private string $status,
        private ?DateTimeInterface $date = null,
        private bool $active = true,
    ) {}

    public static function create(string $orderUuid, string $paymentId, string $status, ?DateTimeInterface $date = null, ?bool $active = true)
    {
        return new static(
            Uuid::create($orderUuid),
            CommonId::create($paymentId),
            $status,
            $date,
            $active,
        );
    }

    public function getOrderUuid()
    {
        return $this->orderUuid;
    }

    public function getPaymentId()
    {
        return $this->paymentId;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setPaid()
    {
        $this->status = PaymentStatus::APPROVED->value;
        $this->date = Carbon::now();
    }

    public function setRefused()
    {
        $this->status = PaymentStatus::REFUSED->value;
        $this->active = false;
    }

    public function isActive()
    {
        return $this->active;
    }
}
