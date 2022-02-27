<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Controllers\Validators;

use Froepstorf\Cryptoportfolio\Controllers\Validators\ParsedBodyValidator;
use Froepstorf\Cryptoportfolio\Controllers\Validators\ValidatableBodyKeys;
use Froepstorf\Cryptoportfolio\Exception\ExpectedKeyIsNotSetException;
use Froepstorf\Cryptoportfolio\Exception\InvalidParsedBodyException;
use PHPUnit\Framework\TestCase;

class ParsedBodyValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private const KEY_1 = 'key1';

    /**
     * @var string
     */
    private const KEY_2 = 'key2';

    public function testThrowsNoExceptionIfParsedBodyIsArray(): void
    {
        $parsedBody = [];

        ParsedBodyValidator::ensuresParsedBodyIsArray($parsedBody);

        $this->addToAssertionCount(1);
    }

    public function testThrowsNoExceptionIfAllKeysInParsedBodyAreSet(): void
    {
        $validatableBodyKeys = new ValidatableBodyKeys([self::KEY_1, self::KEY_2]);
        $parsedBody = [
            self::KEY_1 => 'test',
            self::KEY_2 => 'test2',
        ];

        ParsedBodyValidator::ensureKeysAreSet($parsedBody, $validatableBodyKeys);

        $this->addToAssertionCount(1);
    }

    public function testThrowsExceptionIfBodyNotArray(): void
    {
        $parsedBody = new \stdClass();

        $this->expectException(InvalidParsedBodyException::class);

        ParsedBodyValidator::ensuresParsedBodyIsArray($parsedBody);
    }

    public function testThrowsExceptionIfKeysAreNotSet(): void
    {
        $validatableBodyKeys = new ValidatableBodyKeys([self::KEY_1, self::KEY_2]);
        $parsedBody = [
            self::KEY_1 => 'value',
        ];

        $this->expectException(ExpectedKeyIsNotSetException::class);

        ParsedBodyValidator::ensureKeysAreSet($parsedBody, $validatableBodyKeys);
    }
}
