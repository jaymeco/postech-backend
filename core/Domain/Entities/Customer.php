<?php

namespace Core\Domain\Entities;

use Core\Domain\ValueObjects\Cpf;
use Core\Domain\ValueObjects\CustomerType;
use Core\Domain\ValueObjects\Uuid;

class Customer
{
    private function __construct(
        private Uuid $uuid,
        private CustomerType $type,
        private ?Uuid $userUuid =  null,
        private ?Cpf $cpf = null,
    ) {}

    public static function create(?string $cpf = null, ?string $userUuid = null)
    {
        $type = CustomerType::guest();
        if (!is_null($userUuid)) {
            $type = CustomerType::registered();
        }

        if (!is_null($cpf)) {
            $cpf = Cpf::create($cpf);
        }

        if (!is_null($userUuid)) {
            $userUuid = Uuid::create($userUuid);
        }

        return new static(
            Uuid::create(),
            $type,
            $userUuid,
            $cpf
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

    public function getUserUuid()
    {
        return $this->userUuid;
    }

    public function getCpf()
    {
        return $this->cpf;
    }
}
