<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Controllers\Validators;

use Froepstorf\Cryptoportfolio\Controllers\Validators\ValidatableBodyKeys;
use PHPUnit\Framework\TestCase;

class ValidatableBodyKeysTest extends TestCase
{
    /**
     * @var string
     */
    private const KEY_1 = 'key1';

    /**
     * @var string
     */
    private const KEY_2 = 'key2';

    public function testCanGetKeys(): void
    {
        $keys = [self::KEY_1, self::KEY_2];
        $validatableBodyKeys = new ValidatableBodyKeys($keys);

        $this->assertSame($keys, $validatableBodyKeys->keys);
    }
}
