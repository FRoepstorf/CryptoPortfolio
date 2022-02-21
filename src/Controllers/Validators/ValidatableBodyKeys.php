<?php

namespace Froepstorf\Cryptoportfolio\Controllers\Validators;

class ValidatableBodyKeys
{
    /** @psalm-param list<non-empty-string> $keys */
    public function __construct(public readonly array $keys)
    {
    }
}