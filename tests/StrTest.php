<?php

declare(strict_types=1);

namespace Mikhail\Tests\PrimitiveWrappers;

use Mikhail\PrimitiveWrappers\Str;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Exception;

#[CoversClass(Str::class)]
#[CoversMethod(Str::class, 'length')]
#[CoversMethod(Str::class, 'isMultibyte')]
#[CoversMethod(Str::class, '__toString')]
class StrTest extends TestCase
{
    public static function lengthDataProvider(): array
    {
        return [
            ['foo', 3],
            ['привет', 6],
            ['あいうえお', 5],
        ];
    }

    #[DataProvider('lengthDataProvider')]
    public function testLength(string $str, int $expectedLength): void
    {
        $this->assertEquals($expectedLength, (new Str($str))->length());
    }

    public static function isMultibyteDataProvider(): array
    {
        return [
            ['foo', false],
            ['привет', true],
            ['あいうえお', true],
        ];
    }

    #[DataProvider('isMultibyteDataProvider')]
    public function testIsMultibyte(string $str, bool $expectedIsMultibyte): void
    {
        $this->assertEquals($expectedIsMultibyte, (new Str($str))->isMultibyte());
    }

    public function testToString(): void
    {
        $string = 'Hello, world!';
        $str = new Str($string);
        $this->assertSame($string, (string) $str);
    }

    public function testJsonDecode(): void
    {
        $string = 'Hello, world!';
        $json = json_encode($string);
        $str = (new Str($json))->jsonDecode();
        $this->assertSame($string, $str);
    }
}
