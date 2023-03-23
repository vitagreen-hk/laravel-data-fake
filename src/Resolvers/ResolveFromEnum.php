<?php

namespace Jokersk\datafake\src\Resolvers;

use Spatie\LaravelData\Support\DataProperty;

class ResolveFromEnum {

    public static function resolve(DataProperty $property) {
        foreach($property->type->acceptedTypes as $key => $acceptedType) {
            if (enum_exists($key)) {
                foreach($key::cases() as $case) {
                    return $case;
                }
            }
        }
    }

}
