<?php

namespace Core\Application\Contracts\Repositories;

use Core\Domain\Entities\Product;

interface ProductRepository
{
    public function getByUuid(string $uuid): Product;
}
