<?php

declare(strict_types=1);

namespace Mikhail\Tests\PrimitiveWrappers;

use Mikhail\PrimitiveWrappers\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    public function testLength(): void
    {
        $this->assertEquals(strlen('foo'), Str::length('foo'));
    }

    public function testIsMultibyte(): void
    {
        $str = 'foo';
        $this->assertEquals(false, Str::isMultibyte($str));
        $mbStr = 'あいうえお';
        $this->assertEquals(true, Str::isMultibyte($mbStr));
    }
}