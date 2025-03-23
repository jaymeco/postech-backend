<?php

namespace Core\Domain\ValueObjects;

class CommonId extends ValueObject
{
    public static function create(string $value)
    {
        return new static($value);
    }
}
