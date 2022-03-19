<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Persistence\User;

use Froepstorf\Cryptoportfolio\Domain\User;
use Froepstorf\Cryptoportfolio\Persistence\User\UserId;
use Froepstorf\Cryptoportfolio\Persistence\User\UserReader;
use Froepstorf\Cryptoportfolio\Persistence\User\UserRepository;
use Froepstorf\Cryptoportfolio\Persistence\User\UserWriter;
use Froepstorf\Fixtures\UserProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Persistence\User\UserRepository */
class UserRepositoryTest extends TestCase
{
    private UserReader|MockObject $userReaderMock;

    private UserWriter|MockObject $userWriterMock;

    private readonly User $user;

    private readonly UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->user = UserProvider::build();

        $this->userReaderMock = $this->createMock(UserReader::class);
        $this->userWriterMock = $this->createMock(UserWriter::class);

        $this->userRepository = new UserRepository($this->userReaderMock, $this->userWriterMock);
    }

    public function testCanStoreUser(): void
    {
        $this->userWriterMock->expects($this->once())
            ->method('store')
            ->with($this->user);

        $this->userRepository->store($this->user);
    }

    public function testCanGetUserIdFromUser(): void
    {
        $userIdMock = $this->createMock(UserId::class);

        $this->userReaderMock->expects($this->once())
            ->method('getUserIdFromUser')
            ->with($this->user)
            ->willReturn($userIdMock);

        $this->assertSame($userIdMock, $this->userRepository->getUserIdFromUser($this->user));
    }
}
