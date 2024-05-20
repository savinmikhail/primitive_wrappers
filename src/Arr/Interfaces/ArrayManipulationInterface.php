<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Arr\Interfaces;

use const PHP_INT_MAX;

interface ArrayManipulationInterface
{
    public function merge(BasicArrayInterface $array): static;
    public function slice(int $offset, int $length = PHP_INT_MAX,): static;
    public function slicePreserveKeys(int $offset, int $length = PHP_INT_MAX): static;
    public function filter(callable $callback): static;
    public function map(callable $callback): static;
    public function reduce(callable $callback): mixed;
    public function reduceWithInitial(callable $callback, mixed $initial): mixed;
}
