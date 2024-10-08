<?php

namespace Core\Domain\Entities;

use Core\Domain\ValueObjects\Name;
use Core\Domain\ValueObjects\Uuid;

class Category
{
    private function __construct(
        private Uuid $uuid,
        private Name $name,
    ) {}

    public static function create(string $name)
    {
        return new static(
            Uuid::create(),
            Name::create($name)
        );
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getName()
    {
        return $this->name;
    }
}
