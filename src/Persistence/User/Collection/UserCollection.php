<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User\Collection;

use MongoDB\Collection;

class UserCollection
{
    /** @var string */
    public final const USER_NAME_KEY = 'userName';

    public function __construct(
        public readonly Collection $collection
    ) {
    }
}
