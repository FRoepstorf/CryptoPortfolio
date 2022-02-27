<?php
declare(strict_types=1);

namespace Froepstorf\Fixtures;

use Froepstorf\Cryptoportfolio\Domain\User;

class UserProvider
{
    public const USER_NAME = 'test1';

    public static function build(string $userName = self::USER_NAME): User
    {
        return new User($userName);
    }
}