<?php

namespace Core\Application\Adapters\Dto;

use Core\Application\Dtos\CommonDto;
use Core\Application\Dtos\Customer\CustomerDto;
use Core\Domain\Entities\Customer;

abstract class CustomerDtoAdapter
{
    public static function parse(Customer $customer)
    {
        return new CustomerDto(
            $customer->getUuid()->getValue(),
            $customer->getType()->getValue(),
            !is_null($customer->getName()) ? $customer->getName()->getValue() : null,
            !is_null($customer->getEmail()) ? $customer->getEmail()->getValue() : null,
            !is_null($customer->getCpf()) ? $customer->getCpf()->getValue() : null,
        );
    }
}
