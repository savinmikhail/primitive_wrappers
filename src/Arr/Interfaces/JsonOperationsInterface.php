<?php

namespace Mikhail\PrimitiveWrappers\Arr\Interfaces;

interface JsonOperationsInterface
{
    public function jsonEncode(int $options = 0, int $depth = 512): string;
}
