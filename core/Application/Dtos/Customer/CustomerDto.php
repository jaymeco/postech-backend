<?php

namespace Core\Application\Dtos\Customer;

class CustomerDto
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $type,
        public readonly string $name = null,
        public readonly string $email = null,
        public readonly string $cpf = null,
    ) {}
}
