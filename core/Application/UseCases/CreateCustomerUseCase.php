<?php

namespace Core\Application\UseCases;

use Core\Application\Adapters\Dto\CustomerDtoAdapter;
use Core\Application\Contracts\Repositories\CustomerRepository;
use Core\Application\Dtos\Customer\CustomerDto;
use Core\Domain\Entities\Customer;

class CreateCustomerUseCase
{
    public function __construct(
        private CustomerRepository $customerRepository,
    ) {}

    public function execute(string $email, string $name): CustomerDto
    {
        $customer = Customer::create(null, $name, $email);

        $this->customerRepository->save($customer);

        return CustomerDtoAdapter::parse($customer);
    }
}
