<?php

namespace Tests\Fakes\Providers;

class FakerProvider extends \Faker\Provider\Base
{
    public function word()
    {
        return $this->generator->name();
    }

    public function number(int $digits = 1)
    {
        return $this->generator->randomNumber($digits);
    }

    public function description(int $nbWords = 5)
    {
        return $this->generator->sentence($nbWords);
    }
}
