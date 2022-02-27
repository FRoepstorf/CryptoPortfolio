<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User;

use MongoDB\BSON\ObjectId;

class MongoUserId implements UserId
{
    public function __construct(
        private readonly ObjectId $objectId
    ) {
    }

    public function asString(): string
    {
        return $this->objectId->__toString();
    }
}
