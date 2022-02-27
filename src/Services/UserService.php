<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Services;

use Froepstorf\Cryptoportfolio\Domain\User;
use Froepstorf\Cryptoportfolio\Persistence\User\UserId;
use Froepstorf\Cryptoportfolio\Persistence\User\UserRepository;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function handleNewUser(User $user): void
    {
        $this->userRepository->store($user);
    }

    public function getUserIdFromUser(User $user): UserId
    {
        return $this->userRepository->getUserIdFromUser($user);
    }
}
