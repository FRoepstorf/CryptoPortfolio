<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers;

use Froepstorf\Cryptoportfolio\Domain\CryptoCoin;
use Froepstorf\Cryptoportfolio\Services\PurchaseService;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PurchaseController extends AbstractController
{
    #[Pure] public function __construct(LoggerInterface $logger, private PurchaseService $purchaseService)
    {
        parent::__construct($logger);
    }

    public function registerPurchase(Request $request, Response $response): ResponseInterface
    {
        $body = $request->getParsedBody();
        $cryptoCoin = new CryptoCoin($body['coinName']);

        $this->getLogger()->info(sprintf('Registering purchase of coin "%s"', $cryptoCoin->getName()));

        $this->purchaseService->processPurchase($cryptoCoin);

        return $response;
    }
}