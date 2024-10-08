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
}
