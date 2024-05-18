<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Str\Traits;

use function htmlspecialchars;
use function strip_tags;

trait HtmlTrait
{
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
