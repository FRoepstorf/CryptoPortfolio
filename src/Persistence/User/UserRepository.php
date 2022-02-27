<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User;

use Froepstorf\Cryptoportfolio\Domain\User;

class UserRepository
{
    public function __construct(
        private readonly UserReader $userReader,
        private readonly UserWriter $userWriter
    ) {
    }

    public function store(User $user): void
    {
        $this->userWriter->store($user);
    }

    public function getUserIdFromUser(User $user): UserId
    {
        return $this->userReader->getUserIdFromUser($user);
    }
}
