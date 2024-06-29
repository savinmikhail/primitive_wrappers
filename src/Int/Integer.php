<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Int;

use Error;
use InvalidArgumentException;
use Mikhail\PrimitiveWrappers\Int\Exceptions\IntException;
use Mikhail\PrimitiveWrappers\Str\Exceptions\StrException;
use Mikhail\PrimitiveWrappers\Str\Str;

use function abs;
use function log;
use function pow;
use function sqrt;
use function strval;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Integer
{
    /**
     * @readonly
     */
    protected int $value;
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function toInt(): int
    {
        return $this->value;
    }

    /**
     * @return static
     */
    public function toPositive()
    {
        return new static(abs($this->value));
    }

    /**
     * @return static
     */
    public function toNegative()
    {
        return new static(-abs($this->value));
    }

    public function isNegative(): bool
    {
        return $this->value < 0;
    }

    public function isPositive(): bool
    {
        return $this->value > 0;
    }

    public function toFloat(): float
    {
        return (float) $this->value;
    }

    /**
     * @throws StrException
     */
    public function addLeadingZeroes(int $quantityOfZeroes): Str
    {
        $zeroes = (new Str('0'))->repeat($quantityOfZeroes);
        return new Str($zeroes->toString() . strval($this->value));
    }

    /**
     * @return static
     */
    public function increment()
    {
        return new static($this->value + 1);
    }

    /**
     * @return static
     */
    public function decrement()
    {
        return new static($this->value - 1);
    }

    public function isGreaterThan(int $value): bool
    {
        return $this->value > $value;
    }

    public function isLessThan(int $value): bool
    {
        return $this->value < $value;
    }

    public function isGreaterThanOrEqualTo(int $value): bool
    {
        return $this->value >= $value;
    }

    public function isLessThanOrEqualTo(int $value): bool
    {
        return $this->value <= $value;
    }

    /**
     * @return float|int
     */
    public function power(self $exponent)
    {
        return pow($this->value, $exponent->toInt());
    }

    /**
     * @throws IntException
     * @return float|int
     */
    public function divide(self $divisor)
    {
        try {
            return $this->value / $divisor->value;
        } catch (Error $e) {
            throw new IntException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return static
     */
    public function multiply(self $multiplier)
    {
        return new static($this->value * $multiplier->toInt());
    }

    public function sqrt(): float
    {
        return sqrt($this->value);
    }

    public function log(): float
    {
        return log($this->value);
    }

    public function scaleToRange(float $value, float $min, float $max): float
    {
        if ($min >= $max) {
            throw new InvalidArgumentException("Minimum value must be less than maximum value.");
        }
        $scaledValue = ($value - $min) / ($max - $min);
        return $this->ensureInRange($scaledValue, 0, 1);
    }

    public function ensureInRange(float $value, float $min, float $max): float
    {
        return max($min, min($max, $value));
    }
}
