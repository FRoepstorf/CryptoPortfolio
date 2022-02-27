<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers\Validators;

use Froepstorf\Cryptoportfolio\Exception\ExpectedKeyIsNotSetException;
use Froepstorf\Cryptoportfolio\Exception\InvalidParsedBodyException;

class ParsedBodyValidator
{
    public static function ensuresParsedBodyIsArray(array|object|null $parsedBody): void
    {
        is_array($parsedBody) ?: throw new InvalidParsedBodyException();
    }

    public static function ensureKeysAreSet(array $parsedBody, ValidatableBodyKeys $validatableBodyKeys): void
    {
        /** @psalm-var string $keyToValidate */
        foreach ($validatableBodyKeys->keys as $keyToValidate) {
            array_key_exists($keyToValidate, $parsedBody) ?: throw new ExpectedKeyIsNotSetException();
        }
    }
}
