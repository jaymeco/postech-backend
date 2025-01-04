<?php

namespace Core\Application\Dtos;

class CommonDto
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
    ) {}
}
