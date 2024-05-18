<?php

namespace Mikhail\PrimitiveWrappers\Str\Interfaces;

interface CaseConversionInterface
{
    public function snake(): static;
    public function camel(): static;
    public function kebab(): static;
}
