<?php

namespace Core\Application\UseCases;

use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Contracts\Services\PaymentService;
use Core\Application\Dtos\PaymentRequest;
use Core\Domain\Entities\Order;

class MakeCheckoutUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly PaymentService $paymentService,
    ) {}

    public function execute(string $orderUuid)
    {
        $order = $this->orderRepository->getByUuid($orderUuid);

        $paymentData = $this->requestPayment($order);

        return $paymentData;
    }

    private function requestPayment(Order $order)
    {
        $orderUuid = $order->getUuid()->getValue();

        $paymentRequest = new PaymentRequest(
            $order->getUuid()->getValue(),
            $order->getPrice()->getValue(),
            "http://localhost:8002/api/v1/webhooks/orders/$orderUuid/process-payment",
        );

        return $this->paymentService->requestQrCode($paymentRequest);
    }
}
