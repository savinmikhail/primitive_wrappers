<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers;

use function strlen;
use function mb_strlen;
use function mb_detect_encoding;

class Str
{
    public function __construct(protected string $string)
    {
    }

    public static function length(string $string): int
    {
        return strlen($string);
    }

    public static function isMultibyte(string $string): bool
    {
        $encoding = mb_detect_encoding($string);
        if ($encoding === false) {
            throw new \Exception('Failed to detect encoding');
        }
        return strlen($string) !== mb_strlen($string, $encoding);
    }
}