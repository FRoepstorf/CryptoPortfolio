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
    public function mapPurchase(Request $request): Purchase
    {
        $this->validateRequest($request);
        /** @psalm-var array<string, non-empty-string> $parsedBody */
        $parsedBody = $request->getParsedBody();
        return new Purchase(
            cryptoCoin:  new CryptoCoin($parsedBody[PurchaseSupportedKey::COIN_NAME_KEY->value]),
            amount:  new Amount((float)$parsedBody[PurchaseSupportedKey::AMOUNT_KEY->value]),
            price:  $this->createPrice($parsedBody)
        );
    }

    /**
     * @psalm-param  array<string, non-empty-string> $parsedBody
     * @psalm-suppress ArgumentTypeCoercion
     */
    private function createPrice(array $parsedBody): Price
    {
        $money = new Money(
            amount: $parsedBody[PurchaseSupportedKey::PRICE_KEY->value],
            currency: new Currency($parsedBody[PurchaseSupportedKey::CURRENCY_KEY->value])
        );

        return new Price($money);
    }

    private function validateRequest(Request $request): void
    {
        /** @psalm-var array<string, non-empty-string> $parsedBody */
        $parsedBody = $request->getParsedBody();
        ParsedBodyValidator::ensuresParsedBodyIsArray($parsedBody);
        ParsedBodyValidator::ensureKeysAreSet($parsedBody, PurchaseSupportedKey::getKeyValues());
    }
}