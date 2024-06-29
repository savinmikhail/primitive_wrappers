<?php

namespace Mikhail\PrimitiveWrappers\Str\Interfaces;

interface HtmlInterface
{
    /**
     * @return static
     */
    public function stripTags();
    /**
     * @return static
     */
    public function htmlSpecialChars();
}
