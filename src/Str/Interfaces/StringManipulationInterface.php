<?php

namespace Mikhail\PrimitiveWrappers\Str\Interfaces;

interface StringManipulationInterface
{
    /**
     * @return static
     */
    public function toLower();
    /**
     * @return static
     */
    public function toUpper();
    /**
     * @return static
     */
    public function trim(string $characters = " \n\r\t\v\0");
    public function split(int $length = 1): array;
    /**
     * @return static
     */
    public function capitalize();
    /**
     * @return static
     */
    public function replace(string $search, string $replace, int &$count = 0);
    /**
     * @return static
     */
    public function repeat(int $times);
    /**
     * @return static
     */
    public function sub(int $start, int $length, string $encoding = "UTF-8");
    public function getPosition(string $needle, int $offset = 0, string $encoding = 'UTF-8'): int;
    /**
     * @return static
     */
    public function append(string $suffix);
    /**
     * @return static
     */
    public function prepend(string $suffix);
    /**
     * @return static
     */
    public function truncate(int $length = 100, string $ending = "...");
    /**
     * @return static
     */
    public function reverse();
}
