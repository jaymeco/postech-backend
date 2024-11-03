<?php

namespace Core\Domain\Entities;

use Core\Domain\ValueObjects\Cpf;
use Core\Domain\ValueObjects\CustomerType;
use Core\Domain\ValueObjects\Email;
use Core\Domain\ValueObjects\Name;
use Core\Domain\ValueObjects\Uuid;

class Customer
{
    private function __construct(
        private Uuid $uuid,
        private CustomerType $type,
        private ?Cpf $cpf = null,
        private ?Name $name = null,
        private ?Email $email = null,
    ) {}

    public static function create(?string $cpf = null, ?string $name = null, ?string $email = null)
    {
        $type = CustomerType::guest();
        if (!is_null($name) && !is_null($email)) {
            $type = CustomerType::registered();
        }

        if (!is_null($cpf)) {
            $cpf = Cpf::create($cpf);
        }

        if (!is_null($name)) {
            $name = Name::create($name);
        }

        if (!is_null($email)) {
            $email = Email::create($email);
        }

        return new static(
            Uuid::create(),
            $type,
            $cpf,
            $name,
            $email
        );
    }

    public static function restore(string $uuid, string $type, ?string $cpf = null, ?string $name = null, ?string $email = null)
    {
        if (!is_null($name) && !is_null($email)) {
            $type = CustomerType::registered();
        }

        if (!is_null($cpf)) {
            $cpf = Cpf::create($cpf);
        }

        if (!is_null($name)) {
            $name = Name::create($name);
        }

        if (!is_null($email)) {
            $email = Email::create($email);
        }

        return new static(
            Uuid::create($uuid),
            CustomerType::restore($type),
            $cpf,
            $name,
            $email
        );
    }

    public function getType()
    {
        return $this->type;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCpf()
    {
        return $this->cpf;
    }
}
