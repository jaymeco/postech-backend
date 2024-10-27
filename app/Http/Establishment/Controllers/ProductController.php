<?php

namespace App\Http\Establishment\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Establishment\Requests\CreateProductRequest;
use Core\Application\Services\ProductService;
use Core\Application\UseCases\CreateCustomerUseCase;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $service,
    ) {}

    public function create(CreateProductRequest $request)
    {
        $product = $this->service->create(
            $request->getName(),
            $request->getDescription(),
            $request->getCategoryUuid(),
            $request->getImageUri(),
            $request->getPrice(),
        );

        return response()->json($product, 201);
    }
}
