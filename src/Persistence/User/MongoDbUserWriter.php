<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User;

use Froepstorf\Cryptoportfolio\Domain\User;
use Froepstorf\Cryptoportfolio\Exception\UserAlreadyExistsException;
use Froepstorf\Cryptoportfolio\Persistence\User\Collection\UserCollection;
use MongoDB\Collection;
use MongoDB\Driver\Exception\BulkWriteException;

class MongoDbUserWriter implements UserWriter
{
    private readonly Collection $collection;

    public function __construct(UserCollection $userCollection)
    {
        $this->collection = $userCollection->collection;
    }

    public function store(User $user): void
    {
        try {
            $this->collection->insertOne([
                UserCollection::USER_NAME_KEY => $user->name,
            ]);
        } catch (BulkWriteException $bulkWriteException) {
            $bulkWriteException->getCode() === 11000 ?: throw new UserAlreadyExistsException();

            throw $bulkWriteException;
        }
    }
}
