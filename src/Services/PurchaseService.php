<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Services;

use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseRepository;
use Money\Formatter\AggregateMoneyFormatter;
use Psr\Log\LoggerInterface;

class PurchaseService
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly AggregateMoneyFormatter $aggregateMoneyFormatter,
        private readonly PurchaseRepository $purchaseRepository,
        private readonly UserService $userService
    ) {
    }

    public function processPurchase(Purchase $purchase): void
    {
        $this->logger->info(
            sprintf(
                'Starting to process purchase of coin "%s" amount "%s" for "%s" bought by "%s"',
                $purchase->cryptoCoin->coinName,
                $purchase->amount->value,
                $this->aggregateMoneyFormatter->format($purchase->price->asMoney()),
                $purchase->user->name
            )
        );

        $this->purchaseRepository->store($purchase, $this->userService->getUserIdFromUser($purchase->user));
    }
}
