<?php

namespace Core\Domain\ValueObjects;

use Ramsey\Uuid\Uuid as Uuidv4;

class Uuid extends ValueObject
{
    public static function create(?string $uuid = null)
    {
        if (!is_null($uuid)) {
            return new static($uuid);
        }

        return new static(Uuidv4::uuid4());
    }
}
