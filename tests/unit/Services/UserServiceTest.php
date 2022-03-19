<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Services;

use Froepstorf\Cryptoportfolio\Domain\User;
use Froepstorf\Cryptoportfolio\Persistence\User\UserId;
use Froepstorf\Cryptoportfolio\Persistence\User\UserRepository;
use Froepstorf\Cryptoportfolio\Services\UserService;
use Froepstorf\Fixtures\UserProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Services\UserService */
class UserServiceTest extends TestCase
{
    private UserRepository|MockObject $userRepositoryMock;

    private readonly User $user;

    private readonly UserService $userService;

    protected function setUp(): void
    {
        $this->user = UserProvider::build();
        $this->userRepositoryMock = $this->createMock(UserRepository::class);

        $this->userService = new UserService($this->userRepositoryMock);
    }

    public function testCanHandleNewUser(): void
    {
        $this->userRepositoryMock->expects($this->once())
            ->method('store')
            ->with($this->user);

        $this->userService->handleNewUser($this->user);
    }

    public function testCanGetUserIdFromUser(): void
    {
        $userIdMock = $this->createMock(UserId::class);

        $this->userRepositoryMock->expects($this->once())
            ->method('getUserIdFromUser')
            ->with($this->user)
            ->willReturn($userIdMock);

        $this->assertSame($userIdMock, $this->userService->getUserIdFromUser($this->user));
    }
}
