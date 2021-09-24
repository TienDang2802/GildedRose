<?php

declare(strict_types=1);

namespace Tests\Traits;

use Faker\Factory;

trait WithFaker
{
    protected \Faker\Generator $faker;

    protected function setUpFaker()
    {
        $this->faker = Factory::create();
    }
}
