<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Str\Traits;

use Mikhail\PrimitiveWrappers\Str\Exceptions\StrException;
use ValueError;

use function array_reverse;
use function implode;
use function mb_str_split;
use function mb_strpos;
use function mb_strtolower;
use function mb_strtoupper;
use function mb_substr;
use function str_repeat;
use function str_replace;
use function trim;
use function ucfirst;

trait StringManipulationTrait
{
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
     * cut the string to provided length and append ending
     */
    public function truncate(int $length = 100, string $ending = "..."): static
    {
        return $this->sub(0, $length)->append($ending);
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
}
