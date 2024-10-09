<?php

namespace Core\Application\Contracts\Repositories;

use Core\Domain\Entities\Customer;

interface CustomerRepository
{
    public function save(Customer $customer): void;
}
