<?php

namespace JoeSzeto\LaravelDataFake\Attributes;

use Attribute;
use JoeSzeto\LaravelDataFake\Contracts\FakeAttribute;

#[Attribute]
class FakeFactory implements FakeAttribute
{
    public function __construct(public string $className)
    {
    }

    public function make()
    {
        return $this->className::factory()->create()->id;
    }
}
