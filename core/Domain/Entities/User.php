<?php

namespace Core\Domain\Entities;

use Core\Domain\ValueObjects\Email;
use Core\Domain\ValueObjects\Name;
use Core\Domain\ValueObjects\Uuid;
use Ramsey\Uuid\Uuid as Uuidv4;

class User
{
    private string $password;

    private function __construct(
        private Email $email,
        private Name $name,
        private Uuid $uuid,
    ) {}

    public static function create(string $email, string $name, string $password)
    {
        $instance = new static(
            Email::create($email),
            Name::create($name),
            Uuid::create(Uuidv4::uuid4()),
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
