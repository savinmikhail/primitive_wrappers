<?php

namespace Mikhail\PrimitiveWrappers\Str\Interfaces;

interface CaseConversionInterface
{
    /**
     * @return static
     */
    public function snake();
    /**
     * @return static
     */
    public function camel();
    /**
     * @return static
     */
    public function kebab();
}
