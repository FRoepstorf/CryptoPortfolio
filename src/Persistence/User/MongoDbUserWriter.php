<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User;

use Froepstorf\Cryptoportfolio\Domain\User;
use Froepstorf\Cryptoportfolio\Exception\UserAlreadyExistsException;
use MongoDB\BSON\ObjectId;
use MongoDB\Client;
use MongoDB\Driver\Exception\BulkWriteException;

class MongoDbUserWriter implements UserWriter
{
    public function __construct(private readonly Client $mongoClient)
    {
    }

    public function store(User $user): void
    {
        try {
            $collection = $this->mongoClient->selectCollection('test', 'user');
            $collection->insertOne(['userName' => $user->name]);

        } catch (BulkWriteException $exception) {
            $exception->getCode() === 11000 ?: throw new UserAlreadyExistsException();

            throw $exception;
        }
    }
}