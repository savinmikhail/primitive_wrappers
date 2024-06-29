<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Str\Traits;

use function htmlspecialchars;
use function strip_tags;

trait HtmlTrait
{
    /**
     * Strip HTML and PHP tags from a string
     * @return static
     */
    public function stripTags()
    {
        return new static(strip_tags($this->str));
    }

    /**
     * Convert special characters to HTML entities
     * @return static
     */
    public function htmlSpecialChars()
    {
        return new static(htmlspecialchars($this->str));
    }
}
