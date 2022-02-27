<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Froepstorf\Cryptoportfolio\AppEnvironment;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Sentry\ClientInterface;
use Sentry\State\Scope;
use Slim\Psr7\Response;
use Throwable;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ClientInterface $sentryClient,
        private readonly Scope $scope,
        private readonly LoggerInterface $logger,
        private readonly AppEnvironment $appEnvironment
    ) {
    }

    public function process(
        ServerRequestInterface  $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $throwable) {
            $this->logger->error(
                sprintf('Exception "%s" was thrown with message "%s"', $throwable::class, $throwable->getMessage())
            );
            if ($this->appEnvironment->isProd()) {
                $this->sentryClient->captureException($throwable, $this->scope);
                return new Response(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
            }

            throw $throwable;
        }
    }
}
