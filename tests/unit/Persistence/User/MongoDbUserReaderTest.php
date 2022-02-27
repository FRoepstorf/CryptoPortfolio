<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Persistence\User;

use Froepstorf\Cryptoportfolio\Persistence\User\Collection\UserCollection;
use Froepstorf\Cryptoportfolio\Persistence\User\MongoDbUserReader;
use Froepstorf\Fixtures\UserProvider;
use MongoDB\BSON\ObjectId;
use MongoDB\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Persistence\Purchase\MongoDbPurchaseReader */
class MongoDbUserReaderTest extends TestCase
{
    /**
     * @var string
     */
    private const USER_NAME_KEY = 'userName';

    /**
     * @var string
     */
    private const MONGO_USER_ID = '6219d0912811c72f6029aad2';

    private Collection|MockObject $collection;

    private MongoDbUserReader $mongoDbUserReader;

    protected function setUp(): void
    {
        $this->collection = $this->createMock(Collection::class);
        $this->mongoDbUserReader = new MongoDbUserReader(new UserCollection($this->collection));
    }

    public function testCanGetUserIdFromUser(): void
    {
        $user = UserProvider::build();
        $this->collection->expects($this->once())
            ->method('findOne')
            ->with([
                self::USER_NAME_KEY => $user->name,
            ], [
                'projection' => [
                    self::USER_NAME_KEY => false,
                ],

            ])
            ->willReturn([
                '_id' => new ObjectId(self::MONGO_USER_ID),
            ]);

        $this->assertSame(self::MONGO_USER_ID, $this->mongoDbUserReader->getUserIdFromUser($user)->asString());
    }
}
