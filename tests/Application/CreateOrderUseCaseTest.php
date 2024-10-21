<?php

namespace Tests\Application;

use App\Infra\Repositories\Memory\CategoryMemoryRepository;
use App\Infra\Repositories\Memory\CustomerMemoryRepository;
use App\Infra\Repositories\Memory\OrderMemoryRepository;
use App\Infra\Repositories\Memory\ProductMemoryRepository;
use Core\Application\Services\CustomerService;
use Core\Application\Services\OrderService;
use Core\Application\Services\ProductService;
use Core\Application\UseCases\CreateCustomerUseCase;
use Core\Application\UseCases\CreateOrderUseCase;
use Core\Domain\Base\Enums\CategoryEnum;
use Core\Domain\Base\Enums\OrderStatusEnum;
use Core\Domain\ValueObjects\CustomerType;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Domain\CustomerFaker;
use Tests\Fakes\Domain\ProductFaker;

class CreateOrderUseCaseTest extends TestCase
{
    public function test_should_execute_use_case()
    {
        $repository = new OrderMemoryRepository();
        $customerRepository = new CustomerMemoryRepository();
        $productRepository = new ProductMemoryRepository();
        $useCase = new CreateOrderUseCase($customerRepository, $productRepository, $repository);
        $service = new OrderService($repository);
        $productService = new ProductService($productRepository, new CategoryMemoryRepository());
        $faker = new CustomerFaker();

        $products = [
            $this->createProduct($productService),
            $this->createProduct($productService),
            $this->createProduct($productService),
            $this->createProduct($productService),
            $this->createProduct($productService),
            $this->createProduct($productService)
        ];

        $price = 0;
        foreach ($products as $product) {
            $price += $product->getPrice()->getValue();
        }
        $products = array_map(fn($product) => $product->getUuid()->getValue(), $products);

        $created = $useCase->execute($products, $faker->cpf);

        $order = $service->getByUuid($created->getUuid()->getValue());

        $this->assertEquals($price, $order->getPrice()->getValue());
        $this->assertTrue($order->getStatus()->getUuid()->equals(OrderStatusEnum::CREATED->key()));
        $this->assertCount(count($products), $order->getProducts());
        $this->assertNotNull($order->getCode());
    }

    private function createProduct(ProductService $service, ?string $category = null)
    {
        $fake = new ProductFaker();

        return $service->create(
            $fake->name,
            $fake->description,
            $category ?? CategoryEnum::SNACK->key(),
            $fake->imageUri,
            $fake->price
        );
    }
}
