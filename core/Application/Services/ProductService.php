<?php

namespace Core\Application\Services;

use Core\Application\Contracts\Repositories\CategoryRepository;
use Core\Application\Contracts\Repositories\ProductRepository;
use Core\Domain\Base\Helpers\DirtyValuesHelper;
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

    public function update(
        string $productUuid,
        ?string $name = null,
        ?string $description = null,
        ?string $categoryUuid = null,
        ?string $imageUri = null,
        ?float $price = null
    ) {
        $product = $this->productRepository->getByUuid($productUuid);
        $category = $product->getCategory();
        if (!is_null($categoryUuid)) {
            $category = $this->categoryRepository->getByUuid($categoryUuid);
        }

        $updatedProduct = Product::restore(
            $product->getUuid()->getValue(),
            DirtyValuesHelper::resolve($product->getName()->getValue(), $name),
            DirtyValuesHelper::resolve($product->getDescription(), $description),
            $category,
            DirtyValuesHelper::resolve($product->getImageUri(), $imageUri),
            DirtyValuesHelper::resolve($product->getPrice()->getValue(), $price),
        );

        $this->productRepository->update($updatedProduct);
    }
}
