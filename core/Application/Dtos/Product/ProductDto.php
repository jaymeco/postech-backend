<?php

namespace Core\Application\Dtos\Product;

use Core\Application\Dtos\CommonDto;

class ProductDto
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $description,
        public readonly float $price,
        public readonly string $image_uri,
        public readonly CommonDto $category,
    ) {}
}
