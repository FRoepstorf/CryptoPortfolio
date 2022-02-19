<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers\Purchase;

use Froepstorf\Cryptoportfolio\Controllers\AbstractController;
use Froepstorf\Cryptoportfolio\Services\PurchaseService;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PurchaseController extends AbstractController
{
    #[Pure] public function __construct(
        LoggerInterface $logger,
        private PurchaseService $purchaseService,
        private PurchaseRequestMapper $purchaseRequestMapper
    )
    {
        parent::__construct($logger);
    }

    public function registerPurchase(Request $request, Response $response): ResponseInterface
    {
        $purchase = $this->purchaseRequestMapper->mapPurchase($request);

        $this->purchaseService->processPurchase($purchase);

        return $response;
    }
}