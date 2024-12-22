<?php

namespace App\Infra\Adapters\Models;

use App\Models\Category as Model;
use Core\Domain\Entities\Category;

abstract class CategoryAdapter
{
    public static function parse(Model $model)
    {
        return Category::restore($model->uuid, $model->name);
    }
}
