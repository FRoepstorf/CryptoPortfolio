<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Froepstorf\Cryptoportfolio\Middleware\ErrorHandlerMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Sentry\ClientInterface;
use Sentry\State\Scope;
use Throwable;

/** @covers \Froepstorf\Cryptoportfolio\Middleware\ErrorHandlerMiddleware */
class ErrorHandlerMiddlewareTest extends TestCase
{
    private ClientInterface|MockObject $sentryClientMock;

    private Scope $scope;

    private LoggerInterface|MockObject $loggerMock;

    private ServerRequestInterface|MockObject $serverRequestMock;

    private RequestHandlerInterface|MockObject $requestHandlerMock;

    private ErrorHandlerMiddleware $errorHandlerMiddleware;

    protected function setUp(): void
    {
        $this->serverRequestMock = $this->createMock(ServerRequestInterface::class);
        $this->requestHandlerMock = $this->createMock(RequestHandlerInterface::class);

        $this->sentryClientMock = $this->createMock(ClientInterface::class);
        $this->scope = new Scope();
        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->errorHandlerMiddleware = new ErrorHandlerMiddleware(
            $this->sentryClientMock,
            $this->scope,
            $this->loggerMock
        );
    }

    public function testReturnsHandlersResponseIfNoExceptionWasThrown(): void
    {
        $this->requestHandlerMock->expects($this->once())
            ->method('handle')
            ->with($this->serverRequestMock);

        $this->errorHandlerMiddleware->process($this->serverRequestMock, $this->requestHandlerMock);
    }

    public function testCapturesExceptionWithSentryHandlerIfEnvIsProd(): void
    {
        $thrownException = $this->createMock(Throwable::class);
        $this->requestHandlerMock->expects($this->once())
            ->method('handle')
            ->with($this->serverRequestMock)
            ->willThrowException($thrownException);

        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->sentryClientMock->expects($this->once())
            ->method('captureException')
            ->with($thrownException, $this->scope);

        $actualResponse = $this->errorHandlerMiddleware->process($this->serverRequestMock, $this->requestHandlerMock);

        $this->assertSame(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR, $actualResponse->getStatusCode());
    }
}
