<?php

namespace Core\Application\Services;

use Core\Application\Contracts\Repositories\CategoryRepository;
use Core\Application\Contracts\Repositories\ProductRepository;
use Core\Domain\Entities\Product;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository
    ) {}

    public function create(string $name, string $description, string $categoryUuid, string $imageUri, float $price)
    {
        $category = $this->categoryRepository->getByUuid($categoryUuid);

        $product = Product::create($name, $description, $category, $imageUri, $price);

        $this->productRepository->save($product);

        return $product;
    }
}
