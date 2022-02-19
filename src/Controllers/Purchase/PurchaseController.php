<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers\Purchase;

use Froepstorf\Cryptoportfolio\Controllers\AbstractController;
use Froepstorf\Cryptoportfolio\Domain\Amount;
use Froepstorf\Cryptoportfolio\Domain\Coins\CryptoCoin;
use Froepstorf\Cryptoportfolio\Domain\Price;
use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Froepstorf\Cryptoportfolio\Services\PurchaseService;
use JetBrains\PhpStorm\Pure;
use Money\Currency;
use Money\Money;
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
        $amount = new Amount($body['amount']);
        $money = new Money($body['price'], new Currency($body['currency']));
        $price = new Price($money);
        $purchase = new Purchase($cryptoCoin, $amount, $price);

        $this->getLogger()->info(sprintf('Registering purchase of coin "%s"', $cryptoCoin->coinName));

        $this->purchaseService->processPurchase($purchase);

        return $response;
    }
}