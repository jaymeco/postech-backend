<?php

namespace Core\Domain\Entities;

use Core\Domain\ValueObjects\Email;
use Core\Domain\ValueObjects\Name;
use Ramsey\Uuid\Uuid;

class User
{
    private string $password;

    private function __construct(
        private Email $email,
        private Name $name,
        private string $uuid,
    ) {}

    public static function create(string $email, string $name, string $password)
    {
        $instance = new static(
            Email::create($email),
            Name::create($name),
            Uuid::uuid4(),
        );

        $instance->createPassword($password);

        return $instance;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getPassword()
    {
        return $this->password;
    }

    private function createPassword(string $unsafePassword)
    {
        $this->password = $unsafePassword;
    }
}
