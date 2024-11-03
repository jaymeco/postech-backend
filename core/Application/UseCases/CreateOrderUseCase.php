<?php

namespace Core\Application\UseCases;

use Core\Application\Contracts\Repositories\CustomerRepository;
use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Contracts\Repositories\ProductRepository;
use Core\Domain\Entities\Customer;
use Core\Domain\Entities\Order;
use Core\Domain\Entities\Product;
use Illuminate\Support\Facades\DB;

class CreateOrderUseCase
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private ProductRepository $productRepository,
        private OrderRepository $orderRepository
    ) {}

    public function execute(array $products, ?string $cpf = null): Order
    {
        DB::beginTransaction();
        try {
            $customer = Customer::create($cpf);
            $this->customerRepository->save($customer);

            $order = Order::create($customer->getUuid()->getValue());

            $this->addProductsInOrder($products, $order);

            $this->orderRepository->save($order);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $order;
    }

    private function addProductsInOrder(array $products, Order $order)
    {
        foreach ($products as $productUuid) {
            $product = $this->productRepository->getByUuid($productUuid);

            $order->addProduct($product);
        }
    }
}
