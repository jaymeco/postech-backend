<?php

namespace Tests\Fakes\Domain;

use Illuminate\Foundation\Testing\WithFaker;

class ProductFaker
{
    use WithFaker;


    public string $name;
    public string $description;
    public string $imageUri;
    public float $price;

    public function __construct()
    {
        $this->setUpFaker();

        $this->name = $this->faker->name();
        $this->description = $this->faker->text();
        $this->imageUri = $this->faker->imageUrl();
        $this->price = $this->faker->randomNumber(2);
    }
}
