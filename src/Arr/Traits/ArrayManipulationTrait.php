<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Arr\Traits;

use Mikhail\PrimitiveWrappers\Arr\Exceptions\ArrayException;
use Mikhail\PrimitiveWrappers\Arr\Interfaces\BasicArrayInterface;

use function array_filter;
use function array_merge;
use function array_pop;
use function array_reduce;
use function array_slice;

use const PHP_INT_MAX;

trait ArrayManipulationTrait
{
    public function merge(BasicArrayInterface $array): static
    {
        return new static(array_merge($this->array, $array->array));
    }

    public function slice(int $offset, int $length = PHP_INT_MAX): static
    {
        return new static(array_slice($this->array, $offset, $length));
    }

    public function slicePreserveKeys(int $offset, int $length = PHP_INT_MAX): static
    {
        return new static(array_slice($this->array, $offset, $length, true));
    }

    public function filter(callable $callback): static
    {
        return new static(array_filter($this->array, $callback));
    }

    public function map(callable $callback): static
    {
        return new static(array_map($callback, $this->array));
    }

    public function reduce(callable $callback): mixed
    {
        return array_reduce($this->array, $callback);
    }

    public function reduceWithInitial(callable $callback, mixed $initial): mixed
    {
        return array_reduce($this->array, $callback, $initial);
    }

    public function push(mixed $value): static
    {
        $newArray = $this->array;
        $newArray[] = $value;
        return new static($newArray);
    }

    /**
     * @throws ArrayException
     */
    public function pop(): static
    {
        if ($this->isEmpty()) {
            throw new ArrayException("Cannot pop from an empty array.");
        }
        $newArray = $this->array;
        array_pop($newArray);
        return new static($newArray);
    }

    /**
     * @throws ArrayException
     */
    public function shift(): static
    {
        if ($this->isEmpty()) {
            throw new ArrayException("Cannot shift from an empty array.");
        }
        $newArray = $this->array;
        array_shift($newArray);
        return new static($newArray);
    }

    public function unshift(mixed $value): static
    {
        $newArray = $this->array;
        array_unshift($newArray, $value);
        return new static($newArray);
    }

    public function count(): int
    {
        return count($this->array);
    }

    /**
     * get the number of elements starting from ero (count() - 1)
     * can be useful in iterations
     */
    public function length(): int
    {
        return $this->count() - 1;
    }
}
