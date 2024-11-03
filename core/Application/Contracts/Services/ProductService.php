<?php

namespace Core\Application\Contracts\Services;

use Core\Domain\Entities\Product;

interface ProductService
{
    public function create(string $name, string $description, string $categoryUuid, string $imageUri, float $price): Product;

    public function getByUuid(string $uuid): Product;

    public function update(
        string $productUuid,
        ?string $name = null,
        ?string $description = null,
        ?string $categoryUuid = null,
        ?string $imageUri = null,
        ?float $price = null
    ): void;

    public function delete(string $uuid): void;

    public function getAll(?string $categoryUuid = null): array;
}
