<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User\Collection;

use MongoDB\Collection;

class UserCollection
{
    public const USER_NAME_KEY = 'userName';

    public function __construct(public readonly Collection $collection)
    {
    }
}