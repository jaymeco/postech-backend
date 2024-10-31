<?php

namespace App\Http\Customer\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Customer\Requests\CreateOrderRequest;
use Core\Application\UseCases\CreateOrderUseCase;
use Core\Application\UseCases\MakeCheckoutUseCase;

class OrderController extends Controller
{
    public function __construct() {}

    public function create(CreateOrderRequest $request)
    {
        $useCase = app(CreateOrderUseCase::class);

        $order = $useCase->execute($request->getProducts(), $request->getCustomerCpf());

        return response()->json($order, 201);
    }

    public function checkout(string $orderUuid)
    {
        $useCase = app(MakeCheckoutUseCase::class);

        $useCase->execute($orderUuid);

        return response()->json([], 204);
    }
}
