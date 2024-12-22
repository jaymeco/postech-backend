<?php

namespace App\Infra\Adapters\Models;

use App\Models\Product as Model;
use Core\Domain\Entities\Product;

abstract class ProductAdapter
{
    public static function parse(Model $model)
    {
        return Product::restore(
            $model->uuid,
            $model->name,
            $model->description,
            CategoryAdapter::parse($model->category),
            $model->image_uri,
            $model->price,
        );
    }
}
