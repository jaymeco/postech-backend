<?php

namespace App\Http\Establishment\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Establishment\Requests\CreateProductRequest;
use App\Http\Establishment\Requests\UpdateProductRequest;
use Core\Application\Services\ProductService;
use Core\Application\UseCases\CreateCustomerUseCase;
use Core\Domain\Entities\Product;

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

        return response()->json($this->parseProduct($product), 201);
    }

    public function update(string $uuid, UpdateProductRequest $request)
    {
        $this->service->update(
            $uuid,
            $request->getName(),
            $request->getDescription(),
            $request->getCategoryUuid(),
            $request->getImageUri(),
            $request->getPrice(),
        );

        return response()->json([], 200);
    }

    public function getAllByCategory(string $categoryUuid)
    {
        $products = $this->service->getAll($categoryUuid);

        return response()->json(array_map(fn($product) => $this->parseProduct($product), $products), 200);
    }

    public function delete(string $uuid)
    {
        $this->service->delete($uuid);

        return response()->json([], 204);
    }

    private function parseProduct(Product $product)
    {
        return [
            'uuid' => $product->getUuid()->getValue(),
            'name' => $product->getName()->getValue(),
            'description' => $product->getDescription(),
            'image_uri' => $product->getImageUri(),
            'category' => ['uuid' => $product->getCategory()->getUuid()->getValue(), 'name' => $product->getCategory()->getName()->getValue()],
            'price' => $product->getPrice()->getValue(),
        ];
    }
}
