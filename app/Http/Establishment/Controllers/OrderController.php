<?php

namespace App\Http\Establishment\Controllers;

use App\Http\Controllers\Controller;
use Core\Application\UseCases\Order\FinishOrderUseCase;
use Core\Application\UseCases\Order\GetAllOrdersUseCase;
use Core\Application\UseCases\Order\SendOrderToPreparationUseCase;
use Core\Application\UseCases\Order\UpdateOrderToReadyUseCase;

class OrderController extends Controller
{
    public function list()
    {
        $useCase = app(GetAllOrdersUseCase::class);

        $orders = $useCase->execute();

        return response()->json($orders);
    }

    public function sendToPreparation(string $orderUuid)
    {
        $useCase = app(SendOrderToPreparationUseCase::class);

        $order = $useCase->execute($orderUuid);

        return response()->json($order);
    }

    public function updateToReady(string $orderUuid)
    {
        $useCase = app(UpdateOrderToReadyUseCase::class);

        $order = $useCase->execute($orderUuid);

        return response()->json($order);
    }

    public function finish(string $orderUuid)
    {
        $useCase = app(FinishOrderUseCase::class);

        $order = $useCase->execute($orderUuid);

        return response()->json($order);
    }
}
