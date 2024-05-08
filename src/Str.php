<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers;

use JsonException;
use Mikhail\PrimitiveWrappers\Exceptions\StrException;
use Stringable;
use stdClass;
use ValueError;

use function strlen;
use function mb_strlen;
use function mb_detect_encoding;
use function json_decode;
use function mb_strtolower;
use function mb_strtoupper;
use function trim;
use function ucfirst;
use function str_split;
use function str_replace;
use function str_repeat;

/**
 * anything in ASCII works as in UTF-8, so we use mb_ functions everywhere
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
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

    public function toLower(): self
    {
        $this->str = mb_strtolower($this->str);
        return $this;
    }

    public function toUpper(): self
    {
        $this->str = mb_strtoupper($this->str);
        return $this;
    }

    public function toString(): string
    {
        return $this->str;
    }

    public function trim(string $characters = " \n\r\t\v\0"): self
    {
        $this->str = trim($this->str, $characters);
        return $this;
    }

    /**
     * @throws StrException
     */
    public function split(int $length = 1): array
    {
        try {
            return str_split($this->str, $length);
        } catch (ValueError $e) {
            throw new StrException('Failed to split', 0, $e);
        }
    }

    public function capitalize(): self
    {
        $this->str = ucfirst($this->str);
        return $this;
    }

    /**
     * todo: are we need array values here?
     */
    public function replace(string $search, string $replace, int &$count): self
    {
        $this->str = str_replace($search, $replace, $this->str, $count);
        return $this;
    }

    public function repeat(int $times): self
    {
        $this->str = str_repeat($this->str, $times);
        return $this;
    }
}
