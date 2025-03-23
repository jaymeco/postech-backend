<?php

namespace Core\Application\UseCases;

use App\Exceptions\ApplicationException;
use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Contracts\Repositories\PaymentRepository;
use Core\Application\Dtos\CheckPaymentDto;

class CheckPaymentUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly PaymentRepository $paymentRepository,
    ) {}

    public function execute(string $orderUuid)
    {
        $order = $this->orderRepository->getByUuid($orderUuid);

        $payment = $this->paymentRepository->getActiveByOrderUuid($order->getUuid()->getValue());

        throw_if(is_null($payment), ApplicationException::notFound('payment'));

        return new CheckPaymentDto($payment->getStatus(), $order->getCode()->getValue(), $payment->getDate());
    }
}
