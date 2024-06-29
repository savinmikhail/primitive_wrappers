<?php

declare(strict_types=1);

namespace Mikhail\Tests\PrimitiveWrappers;

use Mikhail\PrimitiveWrappers\Arr\Arr;
use Mikhail\PrimitiveWrappers\Arr\Exceptions\ArrayException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function var_dump;

class ArrayTest extends TestCase
{
    public function testArray(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals($array, $arr->toArray());
    }

    public function testJsonSerialize(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals($array, $arr->jsonSerialize());
    }

    public function testOffsetUnset(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        unset($array['foo']);
        $arr->offsetUnset('foo');
        $this->assertEquals($array, $arr->toArray());
    }

    public function testOffsetGet(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals($array['foo'], $arr->offsetGet('foo'));
    }

    public function testOffsetExists(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertTrue($arr->offsetExists('foo'));
    }

    public function testOffsetSet(): void
    {
        $array = [];
        $arr = new Arr($array);
        $arr->offsetSet('foo', 'bar');
        $this->assertEquals(['foo' => 'bar'], $arr->toArray());
    }

    public static function isEmptyDataProvider(): array
    {
        return [
            [['foo' => 'bar'], false],
            [[], true],
        ];
    }

    public function testIsEmpty(array $array, bool $expected): void
    {
        $arr = new Arr($array);
        $this->assertEquals($expected, $arr->isEmpty());
    }

    public function testContains(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertTrue($arr->contains('bar'));
    }

    public function testKeys(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals(['foo'], $arr->keys());
    }

    public function testValues(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals(['bar'], $arr->values());
    }

    public static function isAssocDataProvider(): array
    {
        return [
            [['foo' => 'bar'], true],
            [['bar'], false],
            [[], false]
        ];
    }

    public function testIsAssoc(array $array, bool $expected): void
    {
        $arr = new Arr($array);
        $this->assertEquals($expected, $arr->isAssoc());
    }

    public function testJsonEncode(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals("{\"foo\":\"bar\"}", $arr->jsonEncode());
    }

    public function testMerge(): void
    {
        $array1 = ['foo' => 'bar'];
        $array2 = ['bar' => 'foo'];
        $arr1 = new Arr($array1);
        $arr2 = new Arr($array2);
        $merged = $arr1->merge($arr2);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $merged->toArray());
    }

    public function testSlice(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals(['foo' => 'bar'], $arr->slice(0, 1)->toArray());
    }

    public function testSlicePreserveKeys(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals(['foo' => 'bar'], $arr->slicePreserveKeys(0, 1)->toArray());
    }

    public function testFilter(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals(['foo' => 'bar'], $arr->filter(static function ($value): bool {
            return is_string($value);
        })->toArray());
    }

    public function testMap(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals(['foo' => 'bar'], $arr->map(static function ($value): bool {
            return is_string($value);
        })->toArray());
    }

    public function testReduce(): void
    {
        $array = [1, 2, 3, 4, 5];
        $arr = new Arr($array);
        $this->assertEquals(15, $arr->reduce(static function ($carry, $item): int {
            $carry += $item;
            return $carry;
        }));
    }

    public function testReduceWithInitial(): void
    {
        $array = [1, 2, 3, 4, 5];
        $arr = new Arr($array);
        $this->assertEquals(16, $arr->reduceWithInitial(static function ($carry, $item): int {
            $carry += $item;
            return $carry;
        }, 1));
    }

    public function testPush(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals(['foo' => 'bar', 0 => 'foo'], $arr->push('foo')->toArray());
    }

    public function testPop(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals([], $arr->pop()->toArray());
    }

    public function testPopEmpty(): void
    {
        $arr = new Arr([]);
        $this->expectException(ArrayException::class);
        $arr->pop()->toArray();
    }

    public function testShift(): void
    {
        $array = ['foo' => 'bar'];
        $arr = new Arr($array);
        $this->assertEquals([], $arr->shift()->toArray());
    }

    public function testShiftEmpty(): void
    {
        $arr = new Arr([]);
        $this->expectException(ArrayException::class);
        $arr->shift()->toArray();
    }

    public function testUnshift(): void
    {
        $array = ['foo'];
        $arr = new Arr($array);
        $this->assertEquals(['bar', 'foo'], $arr->unshift('bar')->toArray());
    }
}
