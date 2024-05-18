<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Str\Traits;

use Mikhail\PrimitiveWrappers\Str\Str;

use function preg_match;
use function str_ends_with;
use function str_starts_with;

trait ValidationTrait
{
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
     * check, if the string contains only 'invisible' symbols, like whitespaces, EOLs, etc.
     */
    public function isBlank(): bool
    {
        return $this->trim()->isEmpty();
    }

    /**
     * check if the string matches provided regular expression
     */
    public function matches(Str $regex): bool
    {
        return preg_match($regex->toString(), $this->str) === 1;
    }

    /**
     * check, whether string contains some chars or not
     */
    public function isEmpty(): bool
    {
        return $this->length() === 0;
    }

    /**
     * check, whether string is in snake case or not
     */
    public function isSnake(): bool
    {
        return $this->matches(new Str('/^[a-z0-9]+(?:_[a-z0-9]+)*$/'));
    }
}
