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

    protected array $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @param mixed $offset
     */
    public function offsetExists($offset): bool
    {
        return isset($this->array[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->array[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->array[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
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
