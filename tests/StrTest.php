<?php

declare(strict_types=1);

namespace Mikhail\Tests\PrimitiveWrappers;

use Mikhail\PrimitiveWrappers\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    public function testIs()
    {
        $this->assertEquals(strlen('foo'), Str::length('foo'));
    }
}