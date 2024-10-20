<?php

namespace Tests\Domain;

use Core\Domain\Base\Enums\CategoryEnum;
use Core\Domain\Entities\Category;
use Core\Domain\Entities\Customer;
use Core\Domain\Entities\Order;
use Core\Domain\Entities\Product;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\Fakes\Domain\ProductFaker;

class OrderTest extends TestCase
{
    public function test_should_create_order()
    {
        $customerUuid = Uuid::uuid4();

        $order = Order::create($customerUuid);
        $products = [$this->createProduct(), $this->createProduct(), $this->createProduct()];
        $totalPrice = $products[0]->getPrice()->getValue() + $products[1]->getPrice()->getValue() + $products[2]->getPrice()->getValue();

        foreach ($products as $product) {
            $order->addProduct($product);
        }
        $this->assertEquals($customerUuid, $order->getCustomerUuid()->getValue());
        $this->assertNotNull($order->getCode()->getValue());
        $this->assertEquals($totalPrice, $order->getPrice()->getValue());
    }

    private function createProduct()
    {
        $fake = new ProductFaker();
        $enum = CategoryEnum::SNACK;

        return Product::create(
            $fake->name,
            $fake->description,
            Category::restore($enum->key(), $enum->name()),
            $fake->imageUri,
            $fake->price
        );
    }
}
