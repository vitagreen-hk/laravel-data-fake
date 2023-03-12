<?php

namespace Jokersk\datafake\src\Attributes;

use Attribute;
use Faker\Generator;
use Jokersk\datafake\src\Contracts\FakeAttribute;

#[Attribute]
class FakeEmail implements FakeAttribute
{
    public function __construct()
    {
    }

    public function make()
    {
        return $this->faker()->safeEmail();
    }

    protected function faker(): Generator
    {
        return app(Generator::class);
    }
}
