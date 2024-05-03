<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers;

use Exception;

use function strlen;
use function mb_strlen;
use function mb_detect_encoding;

/** anything in ASCII works as in UTF-8, so we use mb_ functions everywhere */
class Str
{
    public function __construct(protected string $str)
    {
    }

    public function length(): int
    {
        return mb_strlen($this->str);
    }

    /**
     * @throws Exception
     */
    public function isMultibyte(): bool
    {
        $encoding = mb_detect_encoding($this->str);
        if ($encoding === false) {
            throw new Exception('Failed to detect encoding');
        }
        return strlen($this->str) !== mb_strlen($this->str, $encoding);
    }

 
}