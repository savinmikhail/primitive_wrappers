<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers;

use Error;
use Mikhail\PrimitiveWrappers\Exceptions\IntException;
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
readonly class Integer
{
    public function __construct(protected int $value)
    {
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function toPositive(): static
    {
        return new static(abs($this->value));
    }

    public function toNegative(): static
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

    public function increment(): static
    {
        return new static($this->value + 1);
    }

    public function decrement(): static
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

    public function power(self $exponent): float|int
    {
        return pow($this->value, $exponent->toInt());
    }

    /**
     * @throws IntException
     */
    public function divide(self $divisor): float|int
    {
        try {
            return $this->value / $divisor->value;
        } catch (Error $e) {
            throw new IntException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function multiply(self $multiplier): static
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
}
