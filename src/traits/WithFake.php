<?php

namespace JoeSzeto\LaravelDataFake\traits;

use Exception;
use JoeSzeto\LaravelDataFake\Contracts\FakeAttribute;
use JoeSzeto\LaravelDataFake\Contracts\Fakeable;
use JoeSzeto\LaravelDataFake\Enums\AcceptedType;
use JoeSzeto\LaravelDataFake\Resolvers\ResolveFromEnum;
use Spatie\LaravelData\Support\DataConfig;
use Spatie\LaravelData\Support\DataProperty;

trait WithFake
{
    public static function fake()
    {
        $dataClass = app(DataConfig::class)->getDataClass(static::class);

        return $dataClass->properties->reduce(function (array $payload, DataProperty $property) {
            $name = $property->outputMappedName ?? $property->name;

            if ($property->type->isDataCollectable) {
                $payload[$name] = static::handleIsDataCollectable($property);
                return $payload;
            }

            if (!empty($property->attributes) && $value = static::handleAttributes($property)) {
                $payload[$name] = $value;
                return $payload;
            }

            if ($property->type->dataClass && static::is($property->type->dataClass, Fakeable::class) ) {
                $payload[$name] = $property->type->dataClass::fake();
                return $payload;
            }

            $payload[$name] = ResolveFromEnum::resolve($property);

            if (!$payload[$name]) {
                $payload[$name] = AcceptedType::fromDataTypes($property->type->acceptedTypes)->fake();
            }

            return $payload;
        }, []);
    }

    protected static function is($className, string $contractName): bool
    {
        return in_array($contractName, array_keys(class_implements($className)));
    }

    protected static function handleIsDataCollectable(DataProperty $property)
    {
        if (static::is($property->type->dataClass, Fakeable::class)) {
            return [$property->type->dataClass::fake()];
        }

        throw new Exception('Can not solve faker with class' . $property->type->dataClass . ' without implement' . Fakeable::class);
    }

    protected static function handleAttributes(DataProperty $property)
    {
        foreach ($property->attributes as $attributes) {
            if ($attributes instanceof FakeAttribute) {
                return $attributes->make();
            }
        }
    }
}
