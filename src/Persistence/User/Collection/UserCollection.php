<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User\Collection;

use MongoDB\Collection;

class UserCollection
{
    public function __construct(public readonly Collection $collection)
    {
    }
}