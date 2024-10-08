<?php

namespace Core\Domain\ValueObjects;

class Price extends ValueObject
{
    public static function create(float $price)
    {
        return new static($price);
    }
}
