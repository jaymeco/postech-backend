<?php

namespace Core\Application\UseCases\Product;

use Core\Application\Adapters\Dto\ProductDtoAdapter;
use Core\Application\Contracts\Repositories\CategoryRepository;
use Core\Application\Contracts\Repositories\ProductRepository;
use Core\Application\Dtos\Product\ProductDto;
use Core\Domain\Entities\Product;

class CreateProductUseCase
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CategoryRepository $categoryRepository
    ) {}

    public function execute(string $name, string $description, string $categoryUuid, string $imageUri, float $price): ProductDto
    {
        $category = $this->categoryRepository->getByUuid($categoryUuid);

        $product = Product::create($name, $description, $category, $imageUri, $price);

        $this->productRepository->save($product);

        return ProductDtoAdapter::parse($product);
    }
}
