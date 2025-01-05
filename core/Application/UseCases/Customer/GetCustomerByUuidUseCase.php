<?php

namespace Core\Application\UseCases\Customer;

use Core\Application\Adapters\Dto\CustomerDtoAdapter;
use Core\Application\Contracts\Repositories\CustomerRepository;

class GetCustomerByUuidUseCase
{
    public function __construct(
        private readonly CustomerRepository $repository,
    ) {}

    public function execute(string $customerUuid)
    {
        $customer = $this->repository->getByUuid($customerUuid);

        return CustomerDtoAdapter::parse($customer);
    }
}
