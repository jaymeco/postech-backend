<?php

namespace Tests\Application;

use App\Infra\Repositories\Memory\CustomerMemoryRepository;
use Core\Application\Services\CustomerService;
use Core\Application\UseCases\CreateCustomerUseCase;
use Core\Domain\ValueObjects\CustomerType;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\Domain\CustomerFaker;

class CreateCustomerUseCaseTest extends TestCase
{
    public function test_should_execute_use_case()
    {
        $repository = new CustomerMemoryRepository();
        $useCase = new CreateCustomerUseCase($repository);
        $service = new CustomerService($repository);
        $faker = new CustomerFaker();

        $created = $useCase->execute($faker->email, $faker->name);

        $customer = $service->getByUuid($created->getUuid()->getValue());

        $this->assertEquals($faker->name, $customer->getName()->getValue());
        $this->assertEquals($faker->email, $customer->getEmail()->getValue());
        $this->assertTrue($customer->getType()->equals(CustomerType::registered()));
    }
}
