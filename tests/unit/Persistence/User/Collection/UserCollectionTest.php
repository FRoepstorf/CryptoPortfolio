<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Persistence\User\Collection;

use Froepstorf\Cryptoportfolio\Persistence\User\Collection\UserCollection;
use MongoDB\Collection;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Persistence\User\Collection\UserCollection */
class UserCollectionTest extends TestCase
{
    public function testCanGetMongoCollection(): void
    {
        $mongoCollection = $this->createMock(Collection::class);
        $userCollection = new UserCollection($mongoCollection);

        $this->assertSame($mongoCollection, $userCollection->collection);
    }
}
