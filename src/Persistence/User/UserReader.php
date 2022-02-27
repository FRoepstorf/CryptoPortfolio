<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User;

use Froepstorf\Cryptoportfolio\Domain\User;

interface UserReader
{
    public function getUserIdFromUser(User $user): UserId;
}