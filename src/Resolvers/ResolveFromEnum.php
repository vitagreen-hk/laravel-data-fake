<?php

namespace Vitagreen\LaravelDataFake\Resolvers;

use Spatie\LaravelData\Support\DataProperty;

class ResolveFromEnum {

    public static function resolve(DataProperty $property) {
        foreach($property->type->getAcceptedTypes() as $key => $acceptedType) {
            if (enum_exists($key)) {
                foreach($key::cases() as $case) {
                    return $case;
                }
            }
        }
    }

}
