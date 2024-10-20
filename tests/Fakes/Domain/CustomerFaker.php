<?php

namespace Tests\Fakes\Domain;

use Tests\Fakes\Providers\FakerProvider;

class CustomerFaker
{
    public string $name;
    public string $email;
    public string $cpf;

    public function __construct()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new FakerProvider($faker));

        $this->name = $faker->word();
        $this->email = $faker->email();
        $this->cpf = $faker->cpf();
    }
}
