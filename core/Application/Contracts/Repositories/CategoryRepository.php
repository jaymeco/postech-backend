<?php

namespace Core\Application\Contracts\Repositories;

use Core\Domain\Entities\Category;

interface CategoryRepository
{
    public function getByUuid(string $uuid): Category;
}
