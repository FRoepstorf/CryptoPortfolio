<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User;

use Froepstorf\Cryptoportfolio\Domain\User;
use MongoDB\BSON\ObjectId;
use MongoDB\Client;
use MongoDB\Collection;

class MongoDbUserReader implements UserReader
{
    private Collection $collection;

    public function __construct(private readonly Client $mongoClient)
    {
        $this->collection = $this->mongoClient->selectCollection('test', 'user');
    }

    public function read(string $id): string
    {
        $result = $this->collection->find([
            '_id' => $id
        ]);

        return $result->getId()->serialize();
    }

    public function getUserIdFromUser(User $user): UserId
    {
        $result = $this->collection->findOne([
            'userName' => $user->name
        ],
        [
            'projection' => ['userName' => false]
        ]
        );

        return new MongoUserId($result['_id']);
    }
}