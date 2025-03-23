<?php

namespace Core\Application\Dtos\Auth;

class AuthenticatedDto
{
    public function __construct(
        public readonly string $code,
        public readonly string $accessToken,
    ) {}
}
