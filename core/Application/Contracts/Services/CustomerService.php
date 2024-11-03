<?php

namespace Core\Application\Contracts\Services;

use Core\Domain\Entities\Customer;

interface CustomerService
{
    public function getByUuid(string $uuid): Customer;
}
