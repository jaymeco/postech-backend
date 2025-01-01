<?php

namespace Core\Application\UseCases;

use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Contracts\Repositories\PaymentRepository;
use Core\Application\Contracts\Services\PaymentService;
use Core\Application\Dtos\ProcessPaymentDto;
use Core\Domain\Base\Enums\PaymentStatus;
use Core\Domain\Entities\Order;
use Core\Domain\Entities\Payment;
use Illuminate\Support\Facades\DB;

class ProcessPaymentUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly PaymentService $paymentService,
        private readonly PaymentRepository $paymentRepository,
    ) {}

    public function execute(ProcessPaymentDto $data, string $orderUuid)
    {
        $paymentData = $this->paymentService->findPaymentById($data->paymentId);

        $order = $this->orderRepository->getByUuid($orderUuid);
        try {
            DB::beginTransaction();

            $payment = $this->getPaymentOrCreateIfNotExists($order, $data->paymentId);

            if ($paymentData->isApproved()) {
                $order->defineReceived();
                $payment->setPaid();
            }

            $this->paymentRepository->update($payment);
            $this->orderRepository->update($order);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    private function getPaymentOrCreateIfNotExists(Order $order, string $paymentId)
    {
        $payment = $this->paymentRepository->getActiveByOrderUuid($order->getUuid()->getValue());

        if (is_null($payment)) {
            $payment = Payment::create(
                $order->getUuid()->getValue(),
                $paymentId,
                PaymentStatus::WAITING->value,
            );
            $this->paymentRepository->create($payment);
        }

        return $payment;
    }
}
