<?php

namespace Mikhail\PrimitiveWrappers\Str\Interfaces;

interface StringManipulationInterface
{
    public function toLower(): static;
    public function toUpper(): static;
    public function trim(string $characters = " \n\r\t\v\0"): static;
    public function split(int $length = 1): array;
    public function capitalize(): static;
    public function replace(string $search, string $replace, int &$count = 0): static;
    public function repeat(int $times): static;
    public function sub(int $start, int $length, string $encoding = "UTF-8"): static;
    public function getPosition(string $needle, int $offset = 0, string $encoding = 'UTF-8'): int;
    public function append(string $suffix): static;
    public function prepend(string $suffix): static;
    public function truncate(int $length = 100, string $ending = "..."): static;
    public function reverse(): static;
}
