<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\User;

interface UserId
{
    public function asString(): string;
}
