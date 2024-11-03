<?php

namespace Core\Domain\Entities;

use Core\Domain\ValueObjects\Name;
use Core\Domain\ValueObjects\Price;
use Core\Domain\ValueObjects\Uuid;

class Product
{
    private function __construct(
        private Uuid $uuid,
        private Name $name,
        private string $description,
        private Category $category,
        private string $imageUri,
        private Price $price,
    ) {}

    public static function create(string $name, string $description, Category $category, string $imageUri, float $price)
    {
        return new static(
            Uuid::create(),
            Name::create($name),
            $description,
            $category,
            $imageUri,
            Price::create($price),
        );
    }

    public static function restore(string $uuid, string $name, string $description, Category $category, string $imageUri, float $price)
    {
        return new static(
            Uuid::create($uuid),
            Name::create($name),
            $description,
            $category,
            $imageUri,
            Price::create($price),
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

    public function getDescription()
    {
        return $this->description;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getImageUri()
    {
        return $this->imageUri;
    }

    public function getPrice()
    {
        return $this->price;
    }
}
