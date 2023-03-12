<?php

namespace Jokersk\datafake\src\Enums;

use Exception;
use Faker\Generator;
use Illuminate\Http\UploadedFile;

enum AcceptedType: string
{
    case int = 'int';
    case string = 'string';
    case fileUpload = UploadedFile::class;

    public static function fromDataTypes(array $dataTypes): static
    {
        foreach (array_keys($dataTypes) as $key) {
            if ($instance = static::tryFrom($key)) {
                return $instance;
            }
        }
        throw new Exception('can not resolve AcceptedType with: '. $key);
    }

    protected function getFaker(): Generator
    {
        return app(Generator::class);
    }

    public function fake()
    {
        $faker = $this->getFaker();
        return match ($this) {
            static::int => $faker->randomNumber(1),
            static::string => $faker->words(3, true),
            default => null
        };
    }
}
