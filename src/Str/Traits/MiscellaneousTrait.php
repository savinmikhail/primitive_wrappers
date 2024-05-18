<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Str\Traits;

use Mikhail\PrimitiveWrappers\Str\Exceptions\StrException;
use Mikhail\PrimitiveWrappers\Str\Str;
use ValueError;

use function crypt;
use function explode;
use function preg_match_all;

use const PHP_INT_MAX;

trait MiscellaneousTrait
{
    /**
     * get the words from the string
     */
    public function words(): array
    {
        $pattern = '/\b\w+\b/';
        preg_match_all($pattern, $this->str, $matches);
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
     * check whether the string equals to the provided one
     */
    public function compareTo(Str $string): bool
    {
        return $this->str === $string->str;
    }

    /**
     * check whether the string equals to the provided one, while case being ignored
     */
    public function compareToIgnoreCase(Str $string): bool
    {
        return $this->toLower()->toString() === $string->toLower()->toString();
    }

    /**
     *  check whether the string equals to the provided one
     */
    public function crypt(Str $salt): static
    {
        return new static(crypt($this->str, $salt->toString()));
    }
}
