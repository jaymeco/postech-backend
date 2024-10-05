<?php

namespace Core\Domain\ValueObjects;

class Name extends ValueObject
{
    public static function create(string $name)
    {
        return new static($name);
    }
}
