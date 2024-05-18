<?php

namespace Mikhail\PrimitiveWrappers\Str\Interfaces;

use Mikhail\PrimitiveWrappers\Str\Str;

interface ValidationInterface
{
    public function startsWith(string $needle): bool;
    public function endsWith(string $needle): bool;
    public function contains(string $needle): bool;
    public function containsIgnoreCase(string $needle): bool;
    public function isBlank(): bool;
    public function matches(Str $regex): bool;
    public function isEmpty(): bool;
    public function isSnake(): bool;
}
