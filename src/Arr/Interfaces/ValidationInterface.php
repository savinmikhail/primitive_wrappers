<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Arr\Interfaces;

interface ValidationInterface
{
    public function isEmpty(): bool;
    /**
     * @param mixed $value
     */
    public function contains($value): bool;
    public function keys(): array;
    public function values(): array;
}
