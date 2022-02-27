<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Controllers\User;

use Froepstorf\Cryptoportfolio\Controllers\User\CreateUserSupportedKey;
use PHPUnit\Framework\TestCase;

class CreateUserSupportedKeyTest extends TestCase
{
    public function testCanGetUserNameKey(): void
    {
        $this->assertSame('userName', CreateUserSupportedKey::USER_NAME->value);
    }

    public function testCanGetKeyValues(): void
    {
        $this->assertSame(['userName'], CreateUserSupportedKey::getKeyValues()->keys);
    }
}
