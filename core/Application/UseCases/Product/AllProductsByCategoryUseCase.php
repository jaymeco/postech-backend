<?php

namespace Core\Application\UseCases\Product;

use Core\Application\Adapters\Dto\ProductDtoAdapter;
use Core\Application\Contracts\Repositories\ProductRepository;
use Core\Application\Dtos\Product\ProductDto;

class AllProductsByCategoryUseCase
{
    public function __construct(
        private readonly ProductRepository $repository,
    ) {}

    /**
     * @return ProductDto[]
     */
    public function execute(string $categoryUuid): array
    {
        $products = $this->repository->all($categoryUuid);

        return array_map(fn($product) => ProductDtoAdapter::parse($product), $products);
    }
}
