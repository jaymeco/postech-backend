<?php

namespace Core\Application\UseCases;

use Core\Application\Contracts\Repositories\CustomerRepository;
use Core\Domain\Entities\Customer;

class CreateCustomerUseCase
{
    public function __construct(
        private CustomerRepository $customerRepository,
    ) {}

    public function execute(string $email, string $name)
    {
        $customer = Customer::create(null, $name, $email);

        $this->customerRepository->save($customer);
    }
}
