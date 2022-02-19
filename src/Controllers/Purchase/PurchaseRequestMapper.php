<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers\Purchase;

use Froepstorf\Cryptoportfolio\Controllers\Validators\ParsedBodyValidator;
use Froepstorf\Cryptoportfolio\Domain\Amount;
use Froepstorf\Cryptoportfolio\Domain\Coins\CryptoCoin;
use Froepstorf\Cryptoportfolio\Domain\Price;
use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Money\Currency;
use Money\Money;
use Slim\Psr7\Request;

class PurchaseRequestMapper
{
    private array $parsedBody;

    public function mapPurchase(Request $request): Purchase
    {
        $this->validateRequest($request);
        $this->parsedBody = $request->getParsedBody();
        return new Purchase(
            new CryptoCoin($this->parsedBody[PurchaseSupportedKey::COIN_NAME_KEY->value]),
            new Amount($this->parsedBody[PurchaseSupportedKey::AMOUNT_KEY->value]),
            $this->createPrice()
        );
    }

    private function createPrice(): Price
    {
        $money = new Money(
            $this->parsedBody[PurchaseSupportedKey::PRICE_KEY->value],
            new Currency($this->parsedBody[PurchaseSupportedKey::CURRENCY_KEY->value])
        );

        return new Price($money);
    }

    private function validateRequest(Request $request): void
    {
        $parsedBody = $request->getParsedBody();
        ParsedBodyValidator::ensuresParsedBodyIsArray($parsedBody);
        ParsedBodyValidator::ensureKeysAreSet($parsedBody, PurchaseSupportedKey::getKeyValues());
    }
}