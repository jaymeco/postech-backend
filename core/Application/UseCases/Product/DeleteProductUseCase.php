<?php

namespace Core\Application\UseCases\Product;

use Core\Application\Adapters\Dto\ProductDtoAdapter;
use Core\Application\Contracts\Repositories\ProductRepository;
use Core\Application\Dtos\Product\ProductDto;

class DeleteProductUseCase
{
    public function __construct(
        private readonly ProductRepository $repository,
    ) {}

    public function execute(string $categoryUuid): void
    {
        $product = $this->repository->getByUuid($categoryUuid);

        $this->repository->delete($product);
    }
}
