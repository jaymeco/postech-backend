<?php

namespace App\Http\Establishment\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Establishment\Requests\CreateProductRequest;
use App\Http\Establishment\Requests\UpdateProductRequest;
use Core\Application\Contracts\Services\ProductService;
use Core\Application\UseCases\Product\AllProductsByCategoryUseCase;
use Core\Application\UseCases\Product\CreateProductUseCase;
use Core\Application\UseCases\Product\UpdateProductUseCase;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $service,
    ) {}

    public function create(CreateProductRequest $request)
    {
        $useCase = app(CreateProductUseCase::class);

        $product = $useCase->execute(
            $request->getName(),
            $request->getDescription(),
            $request->getCategoryUuid(),
            $request->getImageUri(),
            $request->getPrice(),
        );

        return response()->json($product, 201);
    }

    public function update(string $uuid, UpdateProductRequest $request)
    {
        $useCase = app(UpdateProductUseCase::class);

        $product = $useCase->execute(
            $uuid,
            $request->getName(),
            $request->getDescription(),
            $request->getCategoryUuid(),
            $request->getImageUri(),
            $request->getPrice(),
        );

        return response()->json($product, 200);
    }

    public function getAllByCategory(string $categoryUuid)
    {
        $useCase = app(AllProductsByCategoryUseCase::class);
        $products = $useCase->execute($categoryUuid);

        return response()->json($products);
    }

    public function delete(string $uuid)
    {
        $this->service->delete($uuid);

        return response()->json([], 204);
    }
}
