<?php

namespace App\Infra\Adapters\Models;

use App\Models\OrderStatus as Model;
use Core\Domain\Entities\OrderStatus;

abstract class OrderStatusAdapter
{
    public static function parse(Model $model)
    {
        return OrderStatus::restore($model->uuid, $model->name);
    }
}
