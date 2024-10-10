<?php

namespace Tests\Domain;

use Core\Domain\Entities\Category;
use Core\Domain\Entities\Customer;
use Core\Domain\Entities\Product;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductTest extends TestCase
{
    public function test_should_create_product()
    {
        $name= 'Misto quente';
        $description = 'Descricao';
        $imageUri = 'http://images.com/test.png';
        $category = Category::restore(Uuid::uuid4(), 'Lanche');
        $price = 10.0;
        $product = Product::create($name, $description, $category, $imageUri, $price);

        $this->assertEquals($name, $product->getName()->getValue());
        $this->assertEquals($description, $product->getDescription());
        $this->assertEquals($category->getUuid()->getValue(), $product->getCategory()->getUuid()->getValue());
        $this->assertEquals($imageUri, $product->getImageUri());
        $this->assertEquals($price, $product->getPrice()->getValue());
    }
}
