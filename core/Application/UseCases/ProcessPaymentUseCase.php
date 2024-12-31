<?php

namespace Core\Application\UseCases;

use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Contracts\Services\PaymentService;
use Core\Application\Dtos\ProcessPaymentDto;

class ProcessPaymentUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly PaymentService $paymentService,
    ) {}

    public function execute(ProcessPaymentDto $data, string $orderUuid)
    {
        $payment = $this->paymentService->findPaymentById($data->paymentId);

        $order = $this->orderRepository->getByUuid($orderUuid);

        if ($payment->isApproved()) {
            $order->defineReceived();
        }

        $this->orderRepository->update($order);
    }
}
