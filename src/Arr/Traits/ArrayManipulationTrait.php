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
    /**
     * @return static
     */
    public function merge(BasicArrayInterface $array)
    {
        return new static(array_merge($this->array, $array->array));
    }

    /**
     * @return static
     */
    public function slice(int $offset, int $length = PHP_INT_MAX)
    {
        return new static(array_slice($this->array, $offset, $length));
    }

    /**
     * @return static
     */
    public function slicePreserveKeys(int $offset, int $length = PHP_INT_MAX)
    {
        return new static(array_slice($this->array, $offset, $length, true));
    }

    /**
     * @return static
     */
    public function filter(callable $callback)
    {
        return new static(
            array_filter($this->array, $callback === null
                ? fn($value, $key): bool => !empty($value)
                : $callback, $callback === null ? ARRAY_FILTER_USE_BOTH : 0)
        );
    }

    /**
     * @return static
     */
    public function map(callable $callback)
    {
        return new static(array_map($callback, $this->array));
    }

    /**
     * @return mixed
     */
    public function reduce(callable $callback)
    {
        return array_reduce($this->array, $callback);
    }

    /**
     * @param mixed $initial
     * @return mixed
     */
    public function reduceWithInitial(callable $callback, $initial)
    {
        return array_reduce($this->array, $callback, $initial);
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function push($value)
    {
        $newArray = $this->array;
        $newArray[] = $value;
        return new static($newArray);
    }

    /**
     * @throws ArrayException
     * @return static
     */
    public function pop()
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
     * @return static
     */
    public function shift()
    {
        if ($this->isEmpty()) {
            throw new ArrayException("Cannot shift from an empty array.");
        }
        $newArray = $this->array;
        array_shift($newArray);
        return new static($newArray);
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function unshift($value)
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
