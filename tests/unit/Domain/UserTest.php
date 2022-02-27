<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Domain;

use Froepstorf\Cryptoportfolio\Domain\User;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Domain\User */
class UserTest extends TestCase
{
    /**
     * @var string
     */
    private const USER_NAME = 'user';

    public function testCanGetUserName(): void
    {
        $user = new User(self::USER_NAME);

        $this->assertSame(self::USER_NAME, $user->name);
    }
}
