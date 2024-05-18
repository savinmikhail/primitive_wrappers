<?php

namespace Mikhail\PrimitiveWrappers\Str\Interfaces;

interface HtmlInterface
{
    public function stripTags(): static;
    public function htmlSpecialChars(): static;
}
