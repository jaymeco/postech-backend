<?php

namespace Core\Application\UseCases\Product;

use Core\Application\Adapters\Dto\ProductDtoAdapter;
use Core\Application\Contracts\Repositories\ProductRepository;

class GetProductByUuidUseCase
{
    public function __construct(
        private readonly ProductRepository $repository,
    ) {}

    public function execute(string $productUuid)
    {
        $product = $this->repository->getByUuid($productUuid);

        return ProductDtoAdapter::parse($product);
    }
}
