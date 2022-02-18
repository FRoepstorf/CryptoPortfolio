<?php
declare(strict_types=1);

namespace Froepstorf\Acceptance;

use Fig\Http\Message\StatusCodeInterface;
use Froepstorf\Cryptoportfolio\AppBuilder;
use Froepstorf\Cryptoportfolio\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

/** @covers \Froepstorf\Cryptoportfolio\Controllers\RootController */
class RootControllerTest extends TestCase
{
    public function testCanGetHelloWordBody(): void
    {
        $requestBuilder = new ServerRequestFactory();
        $request = $requestBuilder->createServerRequest('GET', '/');

        $app = AppBuilder::build(new ContainerBuilder());

        $response = $app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertSame('Hello World!', (string) $response->getBody());
    }
}