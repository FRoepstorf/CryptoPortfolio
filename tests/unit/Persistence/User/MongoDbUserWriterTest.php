<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Persistence\User;

use Froepstorf\Cryptoportfolio\Domain\User;
use Froepstorf\Cryptoportfolio\Exception\UserAlreadyExistsException;
use Froepstorf\Cryptoportfolio\Persistence\User\Collection\UserCollection;
use Froepstorf\Cryptoportfolio\Persistence\User\MongoDbUserWriter;
use Froepstorf\Fixtures\UserProvider;
use MongoDB\Collection;
use MongoDB\Driver\Exception\BulkWriteException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Persistence\User\MongoDbUserWriter */
class MongoDbUserWriterTest extends TestCase
{
    /** @var int */
    private const DUPLICATE_EXCEPTION_CODE = 11000;

    private Collection|MockObject $collectionMock;

    private User $user;

    private readonly MongoDbUserWriter $mongoDbUserWriter;

    protected function setUp(): void
    {
        $this->user = UserProvider::build();

        $this->collectionMock = $this->createMock(Collection::class);
        $userCollection = new UserCollection($this->collectionMock);
        $this->mongoDbUserWriter = new MongoDbUserWriter($userCollection);
    }

    public function testCanInsertUserIntoCollection(): void
    {
        $this->collectionMock->expects($this->once())
            ->method('insertOne')
            ->with([
                UserCollection::USER_NAME_KEY => UserProvider::USER_NAME,
            ]);

        $this->mongoDbUserWriter->store($this->user);
    }

    public function testThrowsUserAlreadyExistsExceptionIfUserAlreadyExists(): void
    {
        $this->expectException(UserAlreadyExistsException::class);

        $bulkWriteException = new BulkWriteException(code: self::DUPLICATE_EXCEPTION_CODE);

        $this->collectionMock->expects($this->once())
            ->method('insertOne')
            ->with([
                UserCollection::USER_NAME_KEY => UserProvider::USER_NAME,
            ])
            ->willThrowException($bulkWriteException);

        $this->mongoDbUserWriter->store($this->user);
    }

    public function testThrowsBulkWriterExceptionIfErrorButUserDoesNotExistYet(): void
    {
        $this->expectException(BulkWriteException::class);

        $bulkWriteException = new BulkWriteException(code: 100);

        $this->collectionMock->expects($this->once())
            ->method('insertOne')
            ->with([
                UserCollection::USER_NAME_KEY => UserProvider::USER_NAME,
            ])
            ->willThrowException($bulkWriteException);

        $this->mongoDbUserWriter->store($this->user);
    }
}
