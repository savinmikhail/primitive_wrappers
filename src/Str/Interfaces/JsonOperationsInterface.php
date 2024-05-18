<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Str\Interfaces;

use stdClass;

interface JsonOperationsInterface
{
    public function jsonDecodeAssociative(int $depth = 512, int $options = JSON_THROW_ON_ERROR): string|array;
    public function jsonDecodeObject(int $depth = 512, int $options = JSON_THROW_ON_ERROR): string|stdClass;
    public function isJson(): bool;
    public function jsonSerialize(): string;
}
