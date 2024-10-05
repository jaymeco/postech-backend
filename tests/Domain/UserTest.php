<?php

namespace Tests\Domain;

use Core\Domain\Entities\User;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_should_create_user()
    {
        $email = "teste@mail.com";
        $password = "12345";
        $name = "User Tester";

        $instance = User::create($email, $name, $password);

        $this->assertEquals($email, $instance->getEmail()->getValue());
        $this->assertEquals($name, $instance->getName()->getValue());
        $this->assertNotNull($instance->getUuid());
    }

    public function test_should_not_create_entity_user_with_invalid_email()
    {
        $email = "teste@.com";
        $password = "12345";
        $name = "User Tester";

        $this->expectException(InvalidArgumentException::class);

        User::create($email, $name, $password);
    }
}
