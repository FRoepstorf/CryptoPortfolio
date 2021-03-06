<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers\Purchase;

use Fig\Http\Message\StatusCodeInterface;
use Froepstorf\Cryptoportfolio\Controllers\AbstractController;
use Froepstorf\Cryptoportfolio\Services\PurchaseService;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PurchaseController extends AbstractController
{
    public function __construct(
        LoggerInterface $logger,
        private readonly PurchaseService $purchaseService,
        private readonly PurchaseRequestMapper $purchaseRequestMapper
    ) {
        parent::__construct($logger);
    }

    public function registerPurchase(Request $request, Response $response): ResponseInterface
    {
        $purchase = $this->purchaseRequestMapper->mapPurchase($request);

        $this->purchaseService->processPurchase($purchase);

        return $response->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
