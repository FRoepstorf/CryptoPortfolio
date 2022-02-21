<?php

namespace Froepstorf\Cryptoportfolio\Controllers\Validators;

interface HasValidatableBodyKeys
{
    public static function getKeyValues(): ValidatableBodyKeys;
}