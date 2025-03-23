<?php

namespace Core\Application\Contracts\Services;

use Core\Application\Dtos\Auth\AuthenticatedDto;
use Core\Application\Dtos\Auth\AuthorizedDto;

interface AuthService
{
    public function authenticate(string $cpf): AuthenticatedDto;

    public function authorizate(string $cpf): AuthorizedDto;
}
