<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Arr\Traits;

use function array_keys;
use function array_values;
use function in_array;
use function range;

trait ValidationTrait
{
    public function isEmpty(): bool
    {
        return empty($this->array);
    }

    public function contains(mixed $value): bool
    {
        return in_array($value, $this->array, true);
    }

    public function keys(): array
    {
        return array_keys($this->array);
    }

    public function values(): array
    {
        return array_values($this->array);
    }

    public function isAssoc(): bool
    {
        if ($this->array === []) {
            return false;
        }
        return array_keys($this->array) !== range(0, $this->length());
    }
}
