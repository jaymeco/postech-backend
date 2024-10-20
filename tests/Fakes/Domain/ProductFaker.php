<?php

namespace Tests\Fakes\Domain;

use Tests\Fakes\Providers\FakerProvider;

class ProductFaker
{
    public string $name;
    public string $description;
    public string $imageUri;
    public float $price;

    public function __construct()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new FakerProvider($faker));

        $this->name = $faker->word();
        $this->description = $faker->sentence();
        $this->price = $faker->number(2);
        $this->imageUri = 'http://example.com/image.png';
    }
}
