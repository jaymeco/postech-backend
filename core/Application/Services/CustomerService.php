<?php

namespace Core\Application\Services;

use Core\Application\Contracts\Repositories\CustomerRepository;
use Core\Application\Contracts\Services\CustomerService as Contract;
use Core\Domain\Entities\Customer;

class CustomerService implements Contract
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
    ) {}

    public function getByUuid(string $uuid): Customer
    {
        return $this->customerRepository->getByUuid($uuid);
    }
}
