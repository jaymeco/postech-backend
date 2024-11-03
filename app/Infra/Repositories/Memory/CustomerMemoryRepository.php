<?php

namespace App\Infra\Repositories\Memory;

use Core\Application\Contracts\Repositories\CustomerRepository;
use Core\Domain\Entities\Customer;
use Error;

class CustomerMemoryRepository implements CustomerRepository
{
    /***@var Customer[] */
    private array $database;

    public function __construct()
    {
        $this->database = [];
    }

    public function save(Customer $customer): void
    {
        $this->database[] = $customer;
    }

    public function getByUuid(string $uuid): Customer
    {
        $founds = array_filter($this->database, function ($customer) use ($uuid) {
            return $customer->getUuid()->equals($uuid);
        });

        if (count($founds) <= 0 || is_null($founds)) {
            // TODO Criar exceptions da aplicacao
            throw new Error('Not found');
        }

        return $founds[array_key_first($founds)];
    }
}
