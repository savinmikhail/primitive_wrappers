<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Arr\Interfaces;

use const PHP_INT_MAX;

interface ArrayManipulationInterface
{
    /**
     * @return static
     */
    public function merge(BasicArrayInterface $array);
    /**
     * @return static
     */
    public function slice(int $offset, int $length = PHP_INT_MAX);
    /**
     * @return static
     */
    public function slicePreserveKeys(int $offset, int $length = PHP_INT_MAX);
    /**
     * @return static
     */
    public function filter(callable $callback);
    /**
     * @return static
     */
    public function map(callable $callback);
    /**
     * @return mixed
     */
    public function reduce(callable $callback);
    /**
     * @param mixed $initial
     * @return mixed
     */
    public function reduceWithInitial(callable $callback, $initial);
}
