<?php

namespace App\Infra\Repositories\Eloquent;

use App\Exceptions\ApplicationException;
use App\Models\Customer;
use App\Models\Order as Model;
use App\Models\OrderStatus as ModelsOrderStatus;
use App\Models\Product;
use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Domain\Base\Enums\OrderStatusEnum;
use Core\Domain\Entities\Category;
use Core\Domain\Entities\Order;
use Core\Domain\Entities\OrderStatus;
use Core\Domain\Entities\Product as EntitiesProduct;
use Illuminate\Support\Facades\DB;

class OrderEloquentRepository extends EloquentRepository implements OrderRepository
{
    public function __construct()
    {
        parent::__construct(Model::class);
    }

    public function save(Order $order): void
    {
        DB::beginTransaction();
        try {
            $model = $this->query->create([
                Model::UUID => $order->getUuid()->getValue(),
                Model::CUSTOMER_ID => Customer::where(Customer::UUID, '=', $order->getCustomerUuid()->getValue())
                    ->first()->id,
                Model::CODE => $order->getCode()->getValue(),
                Model::STATUS_ID => ModelsOrderStatus::where('uuid', '=', $order->getStatus()->getUuid()->getValue())
                    ->first()->id,
                Model::ORDERED_AT => $order->getOrderedAt(),
                Model::PRICE => $order->getPrice()->getValue(),
            ]);

            // Implementar adicao dos items
            $products = collect($order->getProducts())->map(function ($product) {
                return Product::where(Product::UUID, '=', $product->getUuid()->getValue())->first()->id;
            });

            $model->products()->attach($products->toArray());
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function getByUuid(string $uuid): Order
    {
        $model = $this->query->where(Model::UUID, '=', $uuid)
            ->with(['products', 'status'])
            ->first();

        throw_if(is_null($model), ApplicationException::notFound('order', 'uuid'));

        $order = Order::restore(
            $model->uuid,
            Customer::where(Customer::ID, '=', $model->customer_id)->first(),
            $model->code,
            OrderStatus::restore($model->status->uuid, $model->status->name),
            $model->ordered_at,
            $model->price
        );

        $model->products->each(function ($product) use ($order) {
            $entity = EntitiesProduct::restore(
                $product->uuid,
                $product->name,
                $product->description,
                Category::restore($product->category->uuid, $product->category->name),
                $product->image_uri,
                $product->price,
            );

            $order->addProduct($entity);
        });

        return $order;
    }

    public function update(Order $order): void
    {
        $this->query
        ->where(Model::UUID, '=', $order->getUuid()->getValue())
        ->update([
            Model::STATUS_ID => ModelsOrderStatus::where('uuid', '=', $order->getStatus()->getUuid()->getValue())
            ->first()->id,
            Model::PRICE => $order->getPrice()->getValue(),
        ]);
    }

    public function all(): array
    {
        return $this->query->get()->toArray();
    }
}
