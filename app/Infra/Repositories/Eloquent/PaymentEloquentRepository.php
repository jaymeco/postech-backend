<?php

namespace App\Infra\Repositories\Eloquent;

use App\Exceptions\ApplicationException;
use App\Models\Payment as Model;
use Core\Application\Contracts\Repositories\PaymentRepository;
use Core\Domain\Entities\Payment;

class PaymentEloquentRepository extends EloquentRepository implements PaymentRepository
{
    public function __construct()
    {
        parent::__construct(Model::class);
    }

    public function getActiveByOrderUuid(string $orderUuid): Payment|null
    {
        $model = $this->query
            ->where(Model::ORDER_UUID, '=', $orderUuid)
            ->where(Model::ACTIVE, '=', true)
            ->first();

        if (!is_null($model)) {
            return Payment::create($model->order_uuid, $model->payment_id, $model->status, $model->date);
        }

        return null;
    }

    public function create(Payment $payment): void
    {
        $this->query->create([
            Model::ORDER_UUID => $payment->getOrderUuid()->getValue(),
            Model::ACTIVE => $payment->isActive(),
            Model::STATUS => $payment->getStatus(),
            Model::PAYMENT_ID => $payment->getPaymentId()->getValue(),
            Model::DATE => $payment->getDate(),
        ]);
    }

    public function update(Payment $payment): void
    {
        $this->query
            ->where(Model::ORDER_UUID, '=', $payment->getOrderUuid()->getValue())
            ->where(Model::PAYMENT_ID, '=', $payment->getPaymentId()->getValue())
            ->where(Model::ACTIVE, '=', true)
            ->update([
                Model::ORDER_UUID => $payment->getOrderUuid()->getValue(),
                Model::ACTIVE => $payment->isActive(),
                Model::STATUS => $payment->getStatus(),
                Model::PAYMENT_ID => $payment->getPaymentId()->getValue(),
                Model::DATE => $payment->getDate(),
            ]);
    }
}
