<?php

namespace Core\Application\Adapters\Dto;

use Core\Application\Dtos\Product\ProductDto;
use Core\Domain\Entities\Product;

abstract class ProductDtoAdapter
{
    public static function parse(Product $product)
    {
        return new ProductDto(
            $product->getUuid()->getValue(),
            $product->getName()->getValue(),
            $product->getDescription(),
            $product->getPrice()->getValue(),
            $product->getImageUri(),
            CommonDtoAdapter::parse($product->getCategory()),
        );
    }
}
