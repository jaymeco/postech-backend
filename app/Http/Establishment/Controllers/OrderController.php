<?php

namespace App\Http\Establishment\Controllers;

use App\Http\Controllers\Controller;
use Core\Application\Contracts\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $service,
    ) {}

    public function list()
    {
        $orders = $this->service->getAll();

        return response()
            ->json(
                array_map(fn($order) => [
                    'uuid' => $order->getUuid()->getValue(),
                    'code' => $order->getCode()->getValue(),
                    'status' => ['uuid' => $order->getStatus()->getUuid()->getValue(), 'name' => $order->getStatus()->getName()->getValue()],
                    'ordered_at' => $order->getOrderedAt(),
                    'price' => $order->getPrice()->getValue(),
                    'products' => array_map(fn ($product) => [
                        'uuid' => $product->getUuid()->getValue(),
                        'name' => $product->getName()->getValue(),
                        'descritption' => $product->getDescription(),
                        'image_uri' => $product->getImageUri(),
                        'price' => $product->getPrice()->getValue(),
                        'category' => ['uuid' => $product->getCategory()->getUuid()->getValue(), 'name' => $product->getCategory()->getName()->getValue()],
                    ], $order->getProducts())
                ], $orders),
                200,
            );
    }
}
