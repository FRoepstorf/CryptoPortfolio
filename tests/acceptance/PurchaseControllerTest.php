<?php

declare(strict_types=1);

namespace Froepstorf\AcceptanceTest;

use Fig\Http\Message\StatusCodeInterface;
use Froepstorf\AcceptanceTest\helper\DatabaseTestCaseSetup;
use Froepstorf\Cryptoportfolio\AppBuilder;
use Froepstorf\Cryptoportfolio\ContainerBuilder;
use Froepstorf\Cryptoportfolio\Domain\SupportedCurrencies;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;

/**
 * @covers \Froepstorf\Cryptoportfolio\Controllers\Purchase\PurchaseController
 * @covers \Froepstorf\Cryptoportfolio\Controllers\AbstractController
 */
class PurchaseControllerTest extends TestCase
{
    private readonly DatabaseTestCaseSetup $databaseTestCaseSetup;

    private readonly App $app;

    private readonly ServerRequestFactory $serverRequestFactory;

    public function __construct(?string $name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->databaseTestCaseSetup = new DatabaseTestCaseSetup();
    }

    protected function setUp(): void
    {
        $this->databaseTestCaseSetup->setUp();
        $this->app = AppBuilder::build(new ContainerBuilder());
        $this->serverRequestFactory = new ServerRequestFactory();
    }

    public function testCanRegisterPurchase(): void
    {
        $this->databaseTestCaseSetup->seedUserCollection();

        $request = $this->serverRequestFactory->createServerRequest('POST', '/purchase', []);
        $payload = [
            'coinName' => 'AXS',
            'amount' => 20.5,
            'price' => '50000',
            'currency' => SupportedCurrencies::USD->value,
            'userName' => 'test1',
        ];
        $jsonPayload = json_encode($payload, JSON_THROW_ON_ERROR);
        $request->getBody()
            ->write($jsonPayload);
        $request = $request->withHeader('Content-Type', 'application/json');

        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_CREATED, $response->getStatusCode());
    }
}
