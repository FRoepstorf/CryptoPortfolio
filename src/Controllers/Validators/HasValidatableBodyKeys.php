<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers\Validators;

interface HasValidatableBodyKeys
{
    public static function getKeyValues(): ValidatableBodyKeys;
}
