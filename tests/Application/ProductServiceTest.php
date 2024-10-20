<?php

namespace Tests\Application;

use App\Infra\Repositories\Memory\CategoryMemoryRepository;
use App\Infra\Repositories\Memory\ProductMemoryRepository;
use Core\Application\Services\ProductService;
use Core\Domain\Base\Enums\CategoryEnum;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Domain\ProductFaker;

class ProductServiceTest extends TestCase
{
    public function test_should_create_product()
    {
        $service = new ProductService(new ProductMemoryRepository(), new CategoryMemoryRepository());
        $fake = new ProductFaker();

        $created = $service->create(
            $fake->name,
            $fake->description,
            CategoryEnum::SNACK->key(),
            $fake->imageUri,
            $fake->price
        );

        $product = $service->getByUuid($created->getUuid()->getValue());

        $this->assertEquals($fake->name, $product->getName()->getValue());
        $this->assertEquals($fake->description, $product->getDescription());
        $this->assertEquals(CategoryEnum::SNACK->key(), $product->getCategory()->getUuid()->getValue());
        $this->assertEquals($fake->imageUri, $product->getImageUri());
        $this->assertEquals($fake->price, $product->getPrice()->getValue());
    }

    public function test_should_update_product()
    {
        $service = new ProductService(new ProductMemoryRepository(), new CategoryMemoryRepository());
        $fake = new ProductFaker();
        $name = 'Suco de goiaba';
        $category = CategoryEnum::DRINK->key();
        $price = 2.00;
        $description = 'Um suco';

        $created = $service->create(
            $fake->name,
            $fake->description,
            CategoryEnum::SNACK->key(),
            $fake->imageUri,
            $fake->price
        );
        $service->update($created->getUuid()->getValue(), $name, $description, $category, null, $price);
        $product = $service->getByUuid($created->getUuid()->getValue());

        $this->assertEquals($name, $product->getName()->getValue());
        $this->assertEquals($description, $product->getDescription());
        $this->assertEquals($category, $product->getCategory()->getUuid()->getValue());
        $this->assertEquals($fake->imageUri, $product->getImageUri());
        $this->assertEquals($price, $product->getPrice()->getValue());
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

    public function test_should_list_all_product()
    {
        $service = new ProductService(new ProductMemoryRepository(), new CategoryMemoryRepository());

        $initialList = $service->getAll();

        $this->createProduct($service);
        $this->createProduct($service);
        $this->createProduct($service);

        $finalList = $service->getAll();

        $this->assertCount(0, $initialList);
        $this->assertCount(3, $finalList);
    }
}
