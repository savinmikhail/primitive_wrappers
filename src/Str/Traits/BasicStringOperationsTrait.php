<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Str\Traits;

use Mikhail\PrimitiveWrappers\Str\Exceptions\StrException;

use function mb_detect_encoding;
use function mb_strlen;
use function strlen;

trait BasicStringOperationsTrait
{
    /**
     * convert class to string
     */
    public function __toString(): string
    {
        return $this->str;
    }

    /**
     * convert class to string explicitly
     */
    public function toString(): string
    {
        return $this->str;
    }

    /**
     * get the length of the string
     */
    public function length(): int
    {
        return mb_strlen($this->str);
    }

    /**
     * check, whether the string is Ascii or UTF-8
     * @throws StrException
     */
    public function isMultibyte(): bool
    {
        $encoding = $this->detectEncoding();
        return strlen($this->str) !== mb_strlen($this->str, $encoding);
    }

    /**
     * Get string's encoding
     * @throws StrException
     */
    public function detectEncoding(): string
    {
        $encoding = mb_detect_encoding($this->str);
        if ($encoding === false) {
            throw new StrException('Could not detect encoding');
        }
        return $encoding;
    }
}
