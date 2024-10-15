<?php

namespace Core\Application\Contracts\Repositories;

use Core\Domain\Entities\Product;

interface ProductRepository
{
    public function getByUuid(string $uuid): Product;

    public function save(Product $product): void;

    public function update(Product $product): void;

    public function delete(Product $product): void;

    public function all(?string $categoryUuid = null): array;
}
