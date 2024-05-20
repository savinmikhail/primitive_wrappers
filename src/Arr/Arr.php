<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Arr;

use JsonSerializable;
use ArrayAccess;
use Mikhail\PrimitiveWrappers\Arr\Traits\{
    ArrayManipulationTrait,
    JsonOperationsTrait,
    ValidationTrait
};
use Mikhail\PrimitiveWrappers\Arr\Interfaces\{ArrayManipulationInterface,
    BasicArrayInterface,
    JsonOperationsInterface,
    ValidationInterface};

class Arr implements
    ArrayAccess,
    JsonSerializable,
    JsonOperationsInterface,
    ArrayManipulationInterface,
    ValidationInterface,
    BasicArrayInterface
{
    use ArrayManipulationTrait;
    use JsonOperationsTrait;
    use ValidationTrait;

    public function __construct(protected array $array)
    {
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->array[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->array[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->array[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->array[$offset]);
    }

    public function jsonSerialize(): array
    {
        return $this->array;
    }

    public function toArray(): array
    {
        return $this->array;
    }
}
