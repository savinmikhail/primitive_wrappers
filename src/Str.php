<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers;

use JsonException;
use Mikhail\PrimitiveWrappers\Exceptions\StrException;
use Stringable;
use stdClass;
use ValueError;
use JsonSerializable;

use function array_reverse;
use function crypt;
use function explode;
use function implode;
use function lcfirst;
use function preg_match;
use function preg_match_all;
use function preg_replace_callback;
use function strlen;
use function mb_strlen;
use function mb_detect_encoding;
use function json_decode;
use function mb_strtolower;
use function mb_strtoupper;
use function trim;
use function ucfirst;
use function str_replace;
use function str_repeat;
use function mb_substr;
use function mb_strpos;

use const PHP_INT_MAX;

/**
 * anything in ASCII works as in UTF-8, so we use mb_ functions everywhere
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.TooManyMethods) //todo: am i need to split this class?
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @phan-file-suppress PhanRedefinedInheritedInterface
 */
readonly class Str implements Stringable, JsonSerializable
{
    public function __construct(protected string $str)
    {
    }

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

    /**
     * Get associative array from json string
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
     * Get object from json string
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

    /**
     * Convert all upper letters to lower
     */
    public function toLower(): static
    {
        return new static(mb_strtolower($this->str));
    }

    /**
     * convert all lower case letters to upper
     */
    public function toUpper(): static
    {
        return new static(mb_strtoupper($this->str));
    }

    public function trim(string $characters = " \n\r\t\v\0"): static
    {
        $str = trim($this->str, $characters);
        return new static($str);
    }

    /**
     * get array of chunk by their length from string
     * @param int<0,max> $length
     * @throws StrException
     */
    public function split(int $length = 1): array
    {
        try {
            return mb_str_split($this->str, $length);
        } catch (ValueError $e) {
            throw new StrException('Failed to split', 0, $e);
        }
    }

    /**
     * make first letter upper case
     */
    public function capitalize(): static
    {
        return new static(ucfirst($this->str));
    }

    /**
     * replace substring with another substring
     * todo: are we need array values here?
     */
    public function replace(string $search, string $replace, int &$count = 0): static
    {
        return new static(str_replace($search, $replace, $this->str, $count));
    }

    /**
     * get string concatenated with itstatic multiple times
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
     * get substring
     * if you don't provide length, you'll get the whole string, so you don't need this function.
     * so the length argument is required
     */
    public function sub(int $start, int $length, string $encoding = "UTF-8"): static
    {
        return new static(mb_substr($this->str, $start, $length, $encoding));
    }

    /**
     * check, whether string contains some chars or not
     */
    public function isEmpty(): bool
    {
        return $this->length() === 0;
    }

    /**
     * Find position of first occurrence of string in a string
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

    /**
     * add substring to the end of the string
     */
    public function append(string $suffix): static
    {
        return new static($this->str . $suffix);
    }

    /**
     * add substring to the start of the string
     */
    public function prepend(string $suffix): static
    {
        return new static($suffix . $this->str);
    }

    /**
     * Convert the object to a string when JSON encoded.
     */
    public function jsonSerialize(): string
    {
        return $this->str;
    }

    /**
     * check, whether string starts with provided substring or not
     */
    public function startsWith(string $needle): bool
    {
        return str_starts_with($this->str, $needle);
    }

    /**
     * check, whether string ends with provided substring or not
     */
    public function endsWith(string $needle): bool
    {
        return str_ends_with($this->str, $needle);
    }

    /**
     * check, if the string contains at least one occurrence of substring
     */
    public function contains(string $needle): bool
    {
        return str_contains($this->str, $needle);
    }

    /**
     * check, if the string contains at least one occurrence of substring, case is ignored
     */
    public function containsIgnoreCase(string $needle): bool
    {
        return str_contains($this->toLower()->toString(), (new static($needle))->toLower()->toString());
    }

    /**
     * cut the string to provided length and append ending
     */
    public function truncate(int $length = 100, string $ending = "..."): static
    {
        return $this->sub(0, $length)->append($ending);
    }

    /**
     * convert string to snake case
     */
    public function snake(): static
    {
        $callback = static function (array $matches): string {
            // If the first capturing group matches a lowercase letter followed by an uppercase letter
            return !empty($matches[1]) ?
                // Concatenate the lowercase letter from the first capturing group with an underscore and the uppercase
                // letter from the second capturing group
                $matches[1] . '_' . $matches[2] :

                // Replace spaces, hyphens with underscores
                '_';
        };

        // Replace camel case boundaries, spaces, hyphens, and underscores with underscores
        $snake = preg_replace_callback(
            '/([a-z0-9])([A-Z])|[\s-]+/',
            $callback,
            $this->str
        );

        // Convert the resulting string to lowercase
        return (new static($snake))->toLower();
    }

    /**
     * check, whether string is in snake case or not
     */
    public function isSnake(): bool
    {
        return $this->matches(new self('/^[a-z0-9]+(?:_[a-z0-9]+)*$/'));
    }

    /**
     * convert string to camel case
     */
    public function camel(): static
    {
        // Define the callback function
        $callback = static function (array $matches): string {
            // Convert the matched character to uppercase
            return mb_strtoupper($matches[1]);
        };

        // Replace camel case boundaries, spaces, hyphens, and underscores with uppercase letters
        $camel = preg_replace_callback(
            '/(?:[_ -]|^)([a-z0-9])/i', // Match camel case boundaries, spaces, hyphens, and underscores
            $callback,
            $this->str
        );

        // Convert the first character to lowercase
        $camel = lcfirst($camel);

        return new static($camel);
    }

    /**
     * convert string to kebab case
     */
    public function kebab(): static
    {
        $callback = static function (array $matches): string {
            // If the first capturing group matches a lowercase letter followed by an uppercase letter
            return !empty($matches[1]) ?
                // Concatenate the lowercase letter from the first capturing group with an underscore and the uppercase
                // letter from the second capturing group
                $matches[1] . '-' . $matches[2] :

                // Replace spaces, hyphens with underscores
                '-';
        };

        // Replace camel case boundaries, spaces, hyphens, and underscores with underscores
        $snake = preg_replace_callback(
            '/([a-z0-9])([A-Z])|[\s_]+/',
            $callback,
            $this->str
        );

        // Convert the resulting string to lowercase
        return (new static($snake))->toLower();
    }

    /**
     * reverse the given string
     * @throws StrException
     */
    public function reverse(): static
    {
        return new static(
            implode(
                array_reverse(
                    $this->split()
                )
            )
        );
    }

    /**
     * get the words from the string
     */
    public function words(): array
    {
        // Define the regular expression pattern to match words
        $pattern = '/\b\w+\b/';

        // Match all words in the string using the regular expression pattern
        preg_match_all($pattern, $this->str, $matches);

        // Return the array of matched words
        return $matches[0];
    }

    /**
     * Explode the string into an array.
     * @throws StrException
     */
    public function explode(string $separator, int $limit = PHP_INT_MAX): array
    {
        try {
            return explode($separator, $this->str, $limit);
        } catch (ValueError $e) {
            throw new StrException('Failed to explode', 0, $e);
        }
    }

    /**
     * Check if the string is a valid JSON
     */
    public function isJson(): bool
    {
        json_decode($this->str);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * check whether the string equals to the provided one
     */
    public function compareTo(self $string): bool
    {
        return $this->str === $string->str;
    }

    /**
     * check whether the string equals to the provided one, while case being ignored
     */
    public function compareToIgnoreCase(self $string): bool
    {
        return $this->toLower()->toString() === $string->toLower()->toString();
    }

    /**
     * check, if the string contains only 'invisible' symbols, like whitespaces, EOLs, etc.
     */
    public function isBlank(): bool
    {
        return $this->trim()->isEmpty();
    }

    /**
     * check if the string matches provided regular expression
     */
    public function matches(self $regex): bool
    {
        return preg_match($regex->toString(), $this->str) === 1;
    }

    /**
     *  check whether the string equals to the provided one
     */
    public function crypt(self $salt): static
    {
        return new static(crypt($this->str, $salt->toString()));
    }

    /**
     * Strip HTML and PHP tags from a string
     */
    public function stripTags(): static
    {
        return new static(strip_tags($this->str));
    }

    /**
     * Convert special characters to HTML entities
     */
    public function htmlSpecialChars(): static
    {
        return new static(htmlspecialchars($this->str));
    }
}
