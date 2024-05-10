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
 * @phan-file-suppress PhanRedefinedInheritedInterface
 */
readonly class Str implements Stringable
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

    public function toLower(): static
    {
        return new static(mb_strtolower($this->str));
    }

    public function toUpper(): static
    {
        return new static(mb_strtoupper($this->str));
    }

    public function toString(): string
    {
        return $this->str;
    }

    public function trim(string $characters = " \n\r\t\v\0"): static
    {
        $str = trim($this->str, $characters);
        return new static($str);
    }

    /**
     * @param int<0,max> $length
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

    public function capitalize(): static
    {
        return new static(ucfirst($this->str));
    }

    /**
     * todo: are we need array values here?
     */
    public function replace(string $search, string $replace, int &$count = 0): static
    {
        return new static(str_replace($search, $replace, $this->str, $count));
    }

    /**
     * @throws StrException
     */
    public function repeat(int $times): static
    {
        try {
            return new static(str_repeat($this->str, $times));
        } catch (ValueError $e) {
            throw new StrException('Failed to repeat', 0, $e);
        }
    }

    /**
     * if you don't provide length, you'll get the whole string, so you don't need this function.
     * so the length argument is required
     */
    public function sub(int $start, int $length, string $encoding = "UTF-8"): static
    {
        return new static(mb_substr($this->str, $start, $length, $encoding));
    }

    public function isEmpty(): bool
    {
        return $this->str === "";
    }

    /**
     * @param int<0,max> $offset [optional]
     * @throws StrException
     */
    public function getPosition(string $needle, int $offset = 0, string $encoding = 'UTF-8'): int
    {
        $position = mb_strpos($this->str, $needle, $offset, $encoding);
        if ($position === false) {
            throw new StrException('Failed to find position');
        }
        return $position;
    }

    public function append(string $suffix): static
    {
        return new static($this->str . $suffix);
    }

    public function prepend(string $suffix): static
    {
        return new static($suffix . $this->str);
    }
}
