<?php

namespace Tests\Domain;

use Core\Domain\Entities\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function test_should_create_customer()
    {
        $email = 'simple@email.com';
        $name = 'Simple Name';
        $cpf = "00000000000";

        $customer = Customer::create($cpf, $name, $email);

        $this->assertEquals($cpf, $customer->getCpf()->getValue());
        $this->assertNotNull($customer->getUuid());
        $this->assertEquals('REGISTERED', $customer->getType()->getValue());
        $this->assertEquals($name, $customer->getName()->getValue());
        $this->assertEquals($email, $customer->getEmail()->getValue());
    }
}
