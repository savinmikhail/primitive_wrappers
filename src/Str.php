<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers;

use function strlen;

class Str
{
    public function __construct(protected string $string)
    {
    }

    public static function length(string $string): int
    {
        return strlen($string);
    }
}