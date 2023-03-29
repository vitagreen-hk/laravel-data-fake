<?php

namespace JoeSzeto\LaravelDataFake\Resolvers;

use Faker\Generator;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Support\DataProperty;

class ResolveFromAttributes
{
    public static function resolve(DataProperty $property) {
        foreach($property->attributes as $key => $attribute) {
            if ($attribute instanceof Email) {
                return static::faker()->safeEmail();
            }
        }
    }

    protected static function faker() : Generator {
        return app(Generator::class);
    }
}
