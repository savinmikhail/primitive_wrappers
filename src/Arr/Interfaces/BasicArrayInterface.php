<?php

namespace Mikhail\PrimitiveWrappers\Arr\Interfaces;

interface BasicArrayInterface
{
    public function toArray(): array;
    public function __construct(array $array);
}
