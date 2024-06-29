<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Str\Traits;

use JsonException;
use Mikhail\PrimitiveWrappers\Str\Exceptions\StrException;
use stdClass;

use function json_decode;
use function json_last_error;

use const JSON_ERROR_NONE;
use const JSON_THROW_ON_ERROR;

trait JsonOperationsTrait
{
    /**
     * Get associative array from json string
     * The $associative param was removed, due to violation of single responsibility principle
     * @throws StrException
     * @return mixed[]|string
     */
    public function jsonDecodeAssociative(int $depth = 512, int $options = JSON_THROW_ON_ERROR)
    {
        try {
            $decodingResult = json_decode($this->str, true, $depth, $options);
        } catch (JsonException $e) {
            throw new StrException('Failed to decode JSON', 0, $e);
        }
        if ($decodingResult === null) {
            throw new StrException('Failed to decode JSON');
        }
        return $decodingResult;
    }

    /**
     * Get object from json string
     * @throws StrException
     * @return string|\stdClass
     */
    public function jsonDecodeObject(int $depth = 512, int $options = JSON_THROW_ON_ERROR)
    {
        try {
            $decodingResult = json_decode($this->str, false, $depth, $options);
        } catch (JsonException $e) {
            throw new StrException('Failed to decode JSON', 0, $e);
        }
        if ($decodingResult === null) {
            throw new StrException('Failed to decode JSON');
        }
        return $decodingResult;
    }

    /**
     * Check if the string is a valid JSON
     */
    public function isJson(): bool
    {
        json_decode($this->str);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Convert the object to a string when JSON encoded.
     */
    public function jsonSerialize(): string
    {
        return $this->str;
    }
}
