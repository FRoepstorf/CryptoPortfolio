<?php

namespace Froepstorf\UnitTest\Controllers\User;

use Froepstorf\Cryptoportfolio\Controllers\User\CreateUserSupportedKey;
use Froepstorf\Cryptoportfolio\Controllers\User\UserRequestMapper;
use Froepstorf\Cryptoportfolio\Domain\User;
use Froepstorf\Cryptoportfolio\Exception\ExpectedKeyIsNotSetException;
use Froepstorf\Cryptoportfolio\Exception\InvalidParsedBodyException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Request;

/** @covers \Froepstorf\Cryptoportfolio\Controllers\User\UserRequestMapper */
class UserRequestMapperTest extends TestCase
{
    private const USER_NAME = 'user';

    private Request|MockObject $requestMock;

    private UserRequestMapper $userRequestMapper;

    protected function setUp(): void
    {
        $this->requestMock = $this->createMock(Request::class);

        $this->userRequestMapper = new UserRequestMapper();
    }

    public function testCanGetUserIfValidRequest(): void
    {
        $this->requestMock->method('getParsedBody')
            ->willReturn([
                CreateUserSupportedKey::USER_NAME->value => self::USER_NAME
            ]);

        $this->assertInstanceOf(User::class, $this->userRequestMapper->mapCreateUserRequest($this->requestMock));
    }

    public function testThrowsExeceptionIfParsedBodyIsNotAnArray(): void
    {
        $this->requestMock->method('getParsedBody')
            ->willReturn(new \stdClass());

        $this->expectException(InvalidParsedBodyException::class);

        $this->userRequestMapper->mapCreateUserRequest($this->requestMock);
    }

    public function testThrowsExceptionIfMandatoryKeysAreNotSet(): void
    {
        $this->requestMock->method('getParsedBody')
            ->willReturn([]);

        $this->expectException(ExpectedKeyIsNotSetException::class);

        $this->userRequestMapper->mapCreateUserRequest($this->requestMock);
    }
}
