<?php

namespace Core\Domain\ValueObjects;

class CustomerType extends ValueObject
{
    public static function guest()
    {
        return new static("GUEST");
    }

    public static function registered()
    {
        return new static("REGISTERED");
    }
}
