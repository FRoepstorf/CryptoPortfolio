<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User;

use Froepstorf\Cryptoportfolio\Domain\User;
use Froepstorf\Cryptoportfolio\Persistence\User\Collection\UserCollection;
use MongoDB\BSON\ObjectId;
use MongoDB\Client;
use MongoDB\Collection;

class MongoDbUserReader implements UserReader
{
    private Collection $collection;

    public function __construct(UserCollection $userCollection)
    {
        $this->collection = $userCollection->collection;
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
        /** @psalm-var array<array-key, ObjectId>  $result */
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