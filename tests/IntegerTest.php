<?php

namespace Mikhail\Tests\PrimitiveWrappers;

use Mikhail\PrimitiveWrappers\Int\Exceptions\IntException;
use Mikhail\PrimitiveWrappers\Int\Integer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class IntegerTest extends TestCase
{
    public function testToInt(): void
    {
        $int = new Integer(1);
        $this->assertEquals(1, $int->toInt());
    }

    public static function isPositiveDataProvider(): array
    {
        return [
            [-1, false],
            [0, false],
            [1, true],
        ];
    }

    #[DataProvider('isPositiveDataProvider')]
    public function testIsPositive(int $num, bool $expected): void
    {
        $int = new Integer($num);
        $this->assertEquals($expected, $int->isPositive());
    }

    public static function isNegativeDataProvider(): array
    {
        return [
            [-1, true],
            [0, false],
            [1, false],
        ];
    }

    #[DataProvider('isNegativeDataProvider')]
    public function testIsNegative(int $num, bool $expected): void
    {
        $int = new Integer($num);
        $this->assertEquals($expected, $int->isNegative());
    }

    public static function toPositiveDataProvider(): array
    {
        return [
            [-1, 1],
            [0, 0],
            [1, 1],
        ];
    }

    #[DataProvider('toPositiveDataProvider')]
    public function testToPositive(int $num, int $expected): void
    {
        $int = new Integer($num);
        $this->assertEquals($expected, $int->toPositive()->toInt());
    }

    public static function toNegativeDataProvider(): array
    {
        return [
            [-1, -1],
            [0, 0],
            [1, -1],
        ];
    }

    #[DataProvider('toNegativeDataProvider')]
    public function testToNegative(int $num, int $expected): void
    {
        $int = new Integer($num);
        $this->assertEquals($expected, $int->toNegative()->toInt());
    }

    public function testToFloat(): void
    {
        $int = new Integer(1);
        $this->assertEquals(1.00, $int->toFloat());
    }

    public function testAddLeadingZeroes(): void
    {
        $int = new Integer(1);
        $this->assertEquals('0001', $int->addLeadingZeroes(3)->toString());
    }

    public static function incrementDataProvider(): array
    {
        return [
            [-1, 0],
            [1, 2],
        ];
    }

    #[DataProvider('incrementDataProvider')]
    public function testIncrement(int $integer, int $expected): void
    {
        $int = new Integer($integer);
        $this->assertEquals($expected, $int->increment()->toInt());
    }

    public static function decrementDataProvider(): array
    {
        return [
            [-1, -2],
            [1, 0],
        ];
    }

    #[DataProvider('decrementDataProvider')]
    public function testDecrement(int $integer, int $expected): void
    {
        $int = new Integer($integer);
        $this->assertEquals($expected, $int->decrement()->toInt());
    }

    public static function isGreaterThanDataProvider(): array
    {
        return [
            [-1, 0, false],
            [0, -1, true],
            [0, 0, false],
        ];
    }

    #[DataProvider('isGreaterThanDataProvider')]
    public function testIsGreaterThan(int $integer, int $compareTo, bool $expected): void
    {
        $int = new Integer($integer);
        $this->assertEquals($expected, $int->isGreaterThan($compareTo));
    }

    public static function isGreaterThanOrEqualToDataProvider(): array
    {
        return [
            [-1, 0, false],
            [0, -1, true],
            [0, 0, true]
        ];
    }

    #[DataProvider('isGreaterThanOrEqualToDataProvider')]
    public function testIsGreaterThanOrEqualTo(int $integer, int $compareTo, bool $expected): void
    {
        $int = new Integer($integer);
        $this->assertEquals($expected, $int->isGreaterThanOrEqualTo($compareTo));
    }

    public static function isLessThanOrEqualToDataProvider(): array
    {
        return [
            [-1, 0, true],
            [0, -1, false],
            [0, 0, true]
        ];
    }

    #[DataProvider('isLessThanOrEqualToDataProvider')]
    public function testIsLessThanOrEqualTo(int $integer, int $compareTo, bool $expected): void
    {
        $int = new Integer($integer);
        $this->assertEquals($expected, $int->isLessThanOrEqualTo($compareTo));
    }

    public static function isLessThanDataProvider(): array
    {
        return [
            [-1, 0, true],
            [0, -1, false],
            [0, 0, false]
        ];
    }

    #[DataProvider('isLessThanDataProvider')]
    public function testIsLessThan(int $integer, int $compareTo, bool $expected): void
    {
        $int = new Integer($integer);
        $this->assertEquals($expected, $int->isLessThan($compareTo));
    }

    public function testPower(): void
    {
        $int = new Integer(2);
        $this->assertEquals(8, $int->power(new Integer(3)));
    }

    public function testDivide(): void
    {
        $int = new Integer(6);
        $this->assertEquals(2, $int->divide(new Integer(3)));
    }

    public function testDivideByZero(): void
    {
        $int = new Integer(3);
        $this->expectException(IntException::class);
        $int->divide(new Integer(0));
    }

    public function testMultiply(): void
    {
        $int = new Integer(6);
        $this->assertEquals(18, $int->multiply(new Integer(3))->toInt());
    }

    public function testSqrt(): void
    {
        $int = new Integer(9);
        $this->assertEquals(3, $int->sqrt());
    }

    public function testLog(): void
    {
        $int = new Integer(9);
        $this->assertEquals(2.1972245773362196, $int->log());
    }
}
