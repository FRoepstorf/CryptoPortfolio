<?php

namespace Froepstorf\Cryptoportfolio\Controllers\Validators;

class ValidatableBodyKeys
{
    public function __construct(public readonly array $keys)
    {
    }
}