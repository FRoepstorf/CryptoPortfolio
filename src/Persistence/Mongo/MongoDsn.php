<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Mongo;

/** @codeCoverageIgnore */
final class MongoDsn
{
    public function __construct(public readonly string $value)
    {
    }
}
