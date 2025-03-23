<?php

namespace Core\Application\Dtos\Auth;

class AuthorizedDto
{
    public function __construct(
        public readonly string $code,
    ) {}
}
