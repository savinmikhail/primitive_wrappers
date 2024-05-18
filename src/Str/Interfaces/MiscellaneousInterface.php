<?php

namespace Mikhail\PrimitiveWrappers\Str\Interfaces;

use Mikhail\PrimitiveWrappers\Str\Str;

interface MiscellaneousInterface
{
    public function words(): array;
    public function explode(string $separator, int $limit = PHP_INT_MAX): array;
    public function compareTo(Str $string): bool;
    public function compareToIgnoreCase(Str $string): bool;
    public function crypt(Str $salt): static;
}
