<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers;

use Countable;
use Exception;
use JsonException;
use JsonSerializable;
use Mikhail\PrimitiveWrappers\Exceptions\StrException;
use Stringable;
use Serializable;
use stdClass;

use function strlen;
use function mb_strlen;
use function mb_detect_encoding;
use function json_decode;

/** anything in ASCII works as in UTF-8, so we use mb_ functions everywhere */
class Str implements Stringable
{
    public function __construct(protected string $str)
    {
    }

    public function length(): int
    {
        return mb_strlen($this->str);
    }

    /**
     * @throws StrException
     */
    public function isMultibyte(): bool
    {
        $encoding = $this->detectEncoding();
        return strlen($this->str) !== mb_strlen($this->str, $encoding);
    }

    /**
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

    public function __toString(): string
    {
        return $this->str;
    }

    /**
     * The $associative param was removed, due to violation of single responsibility principle
     * @throws StrException
     */
    public function jsonDecodeAssociative(int $depth = 512, int $options = JSON_THROW_ON_ERROR): string|array
    {
        try {
            $decodingResult = json_decode($this->str, true, $depth, $options);
        } catch (JsonException $e) {
            throw new StrException('Failed to decode JSON', 0, $e);
        }
        if ($decodingResult === null) {
            throw new StrException('Failed to decode JSON');
        }
        return $decodingResult;
    }

    /**
     * @throws StrException
     */
    public function jsonDecodeObject(int $depth = 512, int $options = JSON_THROW_ON_ERROR): string|stdClass
    {
        try {
            $decodingResult = json_decode($this->str, false, $depth, $options);
        } catch (JsonException $e) {
            throw new StrException('Failed to decode JSON', 0, $e);
        }
        if ($decodingResult === null) {
            throw new StrException('Failed to decode JSON');
        }
        return $decodingResult;
    }
}
