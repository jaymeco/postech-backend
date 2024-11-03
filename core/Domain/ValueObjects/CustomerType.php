<?php

namespace Core\Domain\ValueObjects;

class CustomerType extends ValueObject
{
    public static function restore(string $type)
    {
        return new static($type);
    }

    public static function guest()
    {
        return new static("GUEST");
    }

    public static function registered()
    {
        return new static("REGISTERED");
    }
}
