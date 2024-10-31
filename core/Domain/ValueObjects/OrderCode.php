<?php

namespace Core\Domain\ValueObjects;

class OrderCode extends ValueObject
{
    public static function generate()
    {
        $hash = md5(now()->getTimestamp());
        $code = "###$hash";

        return new static($code);
    }

    public static function create(string $value)
    {
        return new static($value);
    }
}
