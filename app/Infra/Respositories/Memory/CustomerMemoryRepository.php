<?php

namespace App\Infra\Repositories\Memory;

use Core\Application\Contracts\Repositories\CustomerRepository;
use Core\Domain\Entities\Customer;

class CustomerMemoryRepository implements CustomerRepository
{
    /***@var Custormer[] */
    private array $database;

    public function __construct()
    {
        $this->database = [];
    }

    public function save(Customer $customer): void
    {
        $this->database[] = $customer;
    }
}
