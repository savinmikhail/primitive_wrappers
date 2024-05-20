<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Arr\Traits;

use JsonException;
use Mikhail\PrimitiveWrappers\Arr\Exceptions\ArrayException;

use function json_encode;

trait JsonOperationsTrait
{
    /**
     * @throws ArrayException
     */
    public function jsonEncode(int $options = 0, int $depth = 512): string
    {
        try {
            $encoded = json_encode($this->array, $options, $depth);
        } catch (JsonException $e) {
            throw new ArrayException('Failed to encode JSON', 0, $e);
        }
        if ($encoded === false) {
            throw new ArrayException('Failed to encode JSON');
        }
        return $encoded;
    }
}
