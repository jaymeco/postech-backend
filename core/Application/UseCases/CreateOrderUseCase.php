<?php

namespace Core\Application\UseCases;

use Core\Application\Adapters\Dto\OrderDtoAdapter;
use Core\Application\Contracts\Repositories\CustomerRepository;
use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Contracts\Repositories\ProductRepository;
use Core\Application\Contracts\Services\AuthService;
use Core\Application\Dtos\Order\CreateOrderOutputDto;
use Core\Domain\Entities\Customer;
use Core\Domain\Entities\Order;
use Core\Domain\Entities\Product;
use Illuminate\Support\Facades\DB;

class CreateOrderUseCase
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private ProductRepository $productRepository,
        private OrderRepository $orderRepository,
        private AuthService $authService
    ) {}

    public function execute(array $products, ?string $cpf = null): CreateOrderOutputDto
    {
        DB::beginTransaction();
        try {
            $customer = Customer::create($cpf);
            $this->customerRepository->save($customer);

            $order = Order::create($customer->getUuid()->getValue());

            $this->addProductsInOrder($products, $order);

            $this->orderRepository->save($order);

            $authDto = null;
            if (!is_null($customer->getCpf())) {
                $authDto = $this->authService->authenticate($customer->getCpf()->getValue());
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return new CreateOrderOutputDto(
            OrderDtoAdapter::parse($order),
            !is_null($authDto) ? $authDto->code : null,
            !is_null($authDto) ? $authDto->accessToken : null,
        );
    }

    private function addProductsInOrder(array $products, Order $order)
    {
        foreach ($products as $productUuid) {
            $product = $this->productRepository->getByUuid($productUuid);

            $order->addProduct($product);
        }
    }
}
