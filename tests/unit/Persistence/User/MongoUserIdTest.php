<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Persistence\User;

use Froepstorf\Cryptoportfolio\Persistence\User\MongoUserId;
use MongoDB\BSON\ObjectId;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Persistence\User\MongoUserId */
class MongoUserIdTest extends TestCase
{
    public function testCanGetAsString(): void
    {
        $mongoObjectId = new ObjectId();
        $mongoUserId = new MongoUserId($mongoObjectId);

        $this->assertSame($mongoObjectId->__toString(), $mongoUserId->asString());
    }
}
