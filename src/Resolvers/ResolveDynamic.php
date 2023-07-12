<?php

namespace JoeSzeto\LaravelDataFake\Resolvers;
use Spatie\LaravelData\Support\DataProperty;

class ResolveDynamic
{
    protected array $resolvers = [];
    protected static ?ResolveDynamic $instance = null;
    public static function add(array $arr) {
        static::getInstance()->resolvers = $arr;
    }

    protected static function getInstance() : static {
        if(!static::$instance) {
            static::$instance = new ResolveDynamic;
        }
        return static::$instance;
    }


    public function resolve(DataProperty $property) {
        foreach($this->resolvers as $key => $value) {
            if ( array_key_exists($key, $property->type->acceptedTypes) ) {
                return $value;
            }
        }
    }

    public static function handle(DataProperty $property) {
        return static::getInstance()->resolve($property);
    }
}
