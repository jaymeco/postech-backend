<?php

namespace Core\Domain\ValueObjects;

class Cpf extends ValueObject
{
    public static function create(string $cpf)
    {
        return new static($cpf);
    }
}
