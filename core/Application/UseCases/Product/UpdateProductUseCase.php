<?php

namespace Core\Application\UseCases\Product;

use Core\Application\Adapters\Dto\ProductDtoAdapter;
use Core\Application\Contracts\Repositories\CategoryRepository;
use Core\Application\Contracts\Repositories\ProductRepository;
use Core\Application\Dtos\Product\ProductDto;
use Core\Domain\Base\Helpers\DirtyValuesHelper;
use Core\Domain\Entities\Product;

class UpdateProductUseCase
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CategoryRepository $categoryRepository
    ) {}

    public function execute(
        string $productUuid,
        ?string $name = null,
        ?string $description = null,
        ?string $categoryUuid = null,
        ?string $imageUri = null,
        ?float $price = null,
    ): ProductDto {
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

        return ProductDtoAdapter::parse($updatedProduct);
    }
}
