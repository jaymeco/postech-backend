<?php

namespace Tests\Domain;

use Core\Domain\Entities\Customer;
use Core\Domain\Entities\User;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as UuidFaker;

class CustomerTest extends TestCase
{
    public function test_should_create_customer()
    {
        $userUuid = UuidFaker::uuid4();
        $cpf = "00000000000";

        $customer = Customer::create($cpf, $userUuid);

        $this->assertEquals($cpf, $customer->getCpf()->getValue());
        $this->assertEquals($userUuid, $customer->getUserUuid()->getValue());
        $this->assertNotNull($customer->getUuid());
        $this->assertEquals('REGISTERED', $customer->getType()->getValue());
    }
}
