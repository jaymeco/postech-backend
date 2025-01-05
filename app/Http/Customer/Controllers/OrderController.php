<?php

namespace App\Http\Customer\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Customer\Requests\CreateOrderRequest;
use Core\Application\UseCases\CheckPaymentUseCase;
use Core\Application\UseCases\CreateOrderUseCase;
use Core\Application\UseCases\MakeCheckoutUseCase;
use Core\Application\UseCases\Order\GetOrderByUuidUseCase;
use Core\Domain\Entities\Order;

class OrderController extends Controller
{
    public function create(CreateOrderRequest $request)
    {
        $useCase = app(CreateOrderUseCase::class);

        $order = $useCase->execute($request->getProducts(), $request->getCustomerCpf());

        return response()->json($this->parseOrder($order), 201);
    }

    public function checkOrderPayment(string $orderUuid)
    {
        $useCase = app(CheckPaymentUseCase::class);
        $data = $useCase->execute($orderUuid);

        return response()->json($data);
    }

    public function checkout(string $orderUuid)
    {
        $useCase = app(MakeCheckoutUseCase::class);

        $data = $useCase->execute($orderUuid);

        return response()->json($data);
    }

    public function getByUuid(string $orderUuid)
    {
        $useCase = app(GetOrderByUuidUseCase::class);
        $order = $useCase->execute($orderUuid);

        return response()->json($order, 200);
    }

    private function parseOrder(Order $order)
    {
        return [
            'uuid' => $order->getUuid()->getValue(),
            'code' => $order->getCode()->getValue(),
            'status' => ['uuid' => $order->getStatus()->getUuid()->getValue(), 'name' => $order->getStatus()->getName()->getValue()],
            'ordered_at' => $order->getOrderedAt(),
            'price' => $order->getPrice()->getValue(),
            'products' => array_map(fn($product) => [
                'uuid' => $product->getUuid()->getValue(),
                'name' => $product->getName()->getValue(),
                'descritption' => $product->getDescription(),
                'image_uri' => $product->getImageUri(),
                'price' => $product->getPrice()->getValue(),
                'category' => ['uuid' => $product->getCategory()->getUuid()->getValue(), 'name' => $product->getCategory()->getName()->getValue()],
            ], $order->getProducts())
        ];
    }
}
