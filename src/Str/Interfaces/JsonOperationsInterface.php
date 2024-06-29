<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Str\Interfaces;

use stdClass;

interface JsonOperationsInterface
{
    /**
     * @return mixed[]|string
     */
    public function jsonDecodeAssociative(int $depth = 512, int $options = JSON_THROW_ON_ERROR);
    /**
     * @return string|\stdClass
     */
    public function jsonDecodeObject(int $depth = 512, int $options = JSON_THROW_ON_ERROR);
    public function isJson(): bool;
    public function jsonSerialize(): string;
}
