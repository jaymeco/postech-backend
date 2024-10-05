<?php

namespace Core\Domain\ValueObjects;

abstract class ValueObject
{
    protected function __construct(
        protected mixed $value
    ) {}

    public function getValue()
    {
        return $this->value;
    }
}
