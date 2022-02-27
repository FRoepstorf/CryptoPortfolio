<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User;

use Froepstorf\Cryptoportfolio\Domain\User;
use Froepstorf\Cryptoportfolio\Persistence\User\Collection\UserCollection;
use MongoDB\BSON\ObjectId;
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
        /** @psalm-var array<array-key, string> $result */
        $result = $this->collection->findOne([
            '_id' => $id
        ]);

        return $result['_id'];
    }

    public function getUserIdFromUser(User $user): UserId
    {
        /** @psalm-var array<array-key, ObjectId>  $result */
        $result = $this->collection->findOne([
            UserCollection::USER_NAME_KEY => $user->name
        ],
        [
            'projection' => [UserCollection::USER_NAME_KEY => false]
        ]
        );

        return new MongoUserId($result['_id']);
    }
}