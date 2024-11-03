<?php

namespace Core\Application\Contracts\Repositories;

use Core\Domain\Entities\User;

interface UserRepository
{
    public function save(User $user): void;
}
