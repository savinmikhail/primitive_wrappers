<?php

declare(strict_types=1);

namespace Mikhail\Tests\PrimitiveWrappers;

use Mikhail\PrimitiveWrappers\Exceptions\StrException;
use Mikhail\PrimitiveWrappers\Str;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

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

    public function testIsMultibyteThrowsExceptionWhenEncodingDetectionFails(): void
    {
        // Create a mock object for Str class
        $strMock = $this->getMockBuilder(Str::class)
            ->onlyMethods(['detectEncoding'])
            ->setConstructorArgs([''])
            ->getMock();

        // Set up the mock behavior for detectEncoding method
        $strMock->expects($this->once())
            ->method('detectEncoding')
            ->willThrowException(new StrException('Could not detect encoding'));

        // Assert that a StrException is thrown when isMultibyte is called
        $this->expectException(StrException::class);
        $strMock->isMultibyte();
    }

    public function testDetectEncodingThrowsException(): void
    {
        $this->markTestIncomplete('todo: generate more consistent string failure');
        $str = new Str(random_bytes(10));
        $this->expectException(StrException::class);
        $str->detectEncoding();
    }

    public function testToStringMagic(): void
    {
        $string = 'Hello, world!';
        $str = new Str($string);
        $this->assertSame($string, (string) $str);
    }

    public function testJsonDecodeAssociative(): void
    {
        $string = 'Hello, world!';
        $json = json_encode($string);
        $str = (new Str($json))->jsonDecodeAssociative();
        $this->assertSame($string, $str);
    }

    public function testJsonDecodeObject(): void
    {
        $string = 'Hello, world!';
        $json = json_encode($string);
        $str = (new Str($json))->jsonDecodeObject();
        $this->assertSame($string, $str);
    }

    public function testJsonDecodeErrorAssociative(): void
    {
        $json = "{'some_invalid_json";
        $this->expectException(StrException::class);
        (new Str($json))->jsonDecodeAssociative();
    }

    public function testJsonDecodeErrorObject(): void
    {
        $json = "{'some_invalid_json";
        $this->expectException(StrException::class);
        (new Str($json))->jsonDecodeObject();
    }

    public function testJsonDecodeErrorAssociativeWithoutThrowOnErrorFlag(): void
    {
        $json = "{'some_invalid_json";
        $this->expectException(StrException::class);
        (new Str($json))->jsonDecodeAssociative(options: 0);
    }

    public function testJsonDecodeErrorObjectWithoutThrowOnErrorFlag(): void
    {
        $json = "{'some_invalid_json";
        $this->expectException(StrException::class);
        (new Str($json))->jsonDecodeObject(options: 0);
    }

    public function testToString(): void
    {
        $string = 'Hello, world!';
        $str = new Str($string);
        $this->assertSame($string, $str->toString());
    }

    public function testTrim()
    {
        $string = 'Hello, world!';
        $stringToTrim = $string . '  ' . "\n";
        $str = new Str($stringToTrim);
        $this->assertSame($string, $str->trim()->toString());
    }

    public function testToLower(): void
    {
        $string = 'Hello, world!';
        $str = new Str($string);
        $this->assertSame('hello, world!', $str->toLower()->toString());
    }

    public function testToUpper(): void
    {
        $string = 'hello, world!';
        $str = new Str($string);
        $this->assertSame('HELLO, WORLD!', $str->toUpper()->toString());
    }

    public function testCapitalize(): void
    {
        $string = 'hello, world!';
        $str = new Str($string);
        $this->assertSame('Hello, world!', $str->capitalize()->toString());
    }

    public function testSplitWithNonPositiveInteger(): void
    {
        $string = 'Hello, world!';
        $this->expectException(StrException::class);
        (new Str($string))->split(-1);
    }

    public function testReplace(): void
    {
        $string = 'Hello, world!';
        $str = new Str($string);
        $this->assertSame('Hello, worlb!', $str->replace('d', 'b')->toString());
    }

    public function testRepeatWithNonPositiveTimes(): void
    {
        $string = 'H';
        $str = new Str($string);
        $this->expectException(StrException::class);
        $str->repeat(-2);
    }

    public function testRepeatWithPositiveTimes(): void
    {
        $string = 'H';
        $str = new Str($string);
        $this->assertSame('HH', $str->repeat(2)->toString());
    }

    public function testSub(): void
    {
        $string = 'Hello, world!';
        $str = new Str($string);
        $this->assertSame('H', $str->sub(0, 1)->toString());
    }

    public static function isEmptyDataProvider(): array
    {
        return [
            ['foo', false],
            ['', true],
        ];
    }

    #[DataProvider('isEmptyDataProvider')]
    public function testIsEmpty(string $string, bool $expectedResult): void
    {
        $str = new Str($string);
        $this->assertEquals($expectedResult, $str->isEmpty());
    }
}
