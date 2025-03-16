<?php

namespace App\Infra\Adapters\Models;

use App\Models\Customer as CustomerModel;
use App\Models\Order as Model;
use App\Models\OrderStatus as OrderStatusModel;
use Core\Domain\Entities\Order;
use Illuminate\Support\Collection;

abstract class OrderAdapter
{
    public static function parse(
        Model $model,
    ) {
        return Order::restore(
            $model->uuid,
            $model->customer->uuid,
            $model->code,
            OrderStatusAdapter::parse($model->status),
            $model->ordered_at,
            $model->price,
            self::parseProducts($model->products),
        );
    }

    private static function parseProducts(Collection $products)
    {
        return $products
            ->map(fn($product) => ProductAdapter::parse($product))
            ->toArray();
    }
}
