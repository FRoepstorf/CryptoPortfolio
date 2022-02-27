<?php

namespace Froepstorf\UnitTest\Controllers\Validators;

use Froepstorf\Cryptoportfolio\Controllers\Validators\ValidatableBodyKeys;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Controllers\Validators\ValidatableBodyKeys */
class ValidatableBodyKeysTest extends TestCase
{
    private const KEY_1 = 'key1';
    private const KEY_2 = 'key2';

    public function testCanGetKeys(): void
    {
        $keys = [self::KEY_1, self::KEY_2];
        $validatableBodyKeys = new ValidatableBodyKeys($keys);

        $this->assertSame($keys, $validatableBodyKeys->keys);
    }
}
