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

    public function equals($object): bool
    {
        if ($object instanceof ValueObject) {
            return $this->getValue() == $object->getValue();
        }

        return $this->getValue() == $object;
    }
}
