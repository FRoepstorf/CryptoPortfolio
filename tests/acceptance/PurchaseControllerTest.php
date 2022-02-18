<?php
declare(strict_types=1);

namespace Froepstorf\Acceptance;

use Fig\Http\Message\StatusCodeInterface;
use Froepstorf\Cryptoportfolio\AppBuilder;
use Froepstorf\Cryptoportfolio\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

/** @covers \Froepstorf\Cryptoportfolio\Controllers\PurchaseController */
class PurchaseControllerTest extends TestCase
{
    public function testCanRegisterPurchase(): void
    {
        $requestBuilder = new ServerRequestFactory();
        $request = $requestBuilder->createServerRequest('POST', '/purchase', [

        ]);
        $payload = [
            'coinName' => 'AXS'
        ];
        $jsonPayload = json_encode($payload, JSON_THROW_ON_ERROR);
        $request->getBody()->write($jsonPayload);
        $request = $request->withHeader('Content-Type', 'application/json');

        $app = AppBuilder::build(new ContainerBuilder());

        $response = $app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}