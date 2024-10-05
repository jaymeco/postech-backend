<?php

namespace Core\Domain\ValueObjects;

use InvalidArgumentException;

class Email extends ValueObject
{
    public static function create(string $email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email");
        }
        return new static($email);
    }
}
