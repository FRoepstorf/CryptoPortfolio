<?php

declare(strict_types=1);

namespace Froepstorf\AcceptanceTest\helper;

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\ContainerBuilder;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\Collection\PurchaseCollection;
use Froepstorf\Cryptoportfolio\Persistence\User\Collection\UserCollection;

class DatabaseTestCaseSetup
{
    private readonly UserCollection $userCollection;

    private readonly PurchaseCollection $purchaseCollection;

    public function __construct()
    {
        $container = (new ContainerBuilder())->build(AppEnvironment::TEST);
        $this->userCollection = $container->get(UserCollection::class);
        $this->purchaseCollection = $container->get(PurchaseCollection::class);
    }

    public function setUp(): void
    {
        $this->dropCollections();
    }

    public function seedUserCollection(): void
    {
        $insertManyResult = $this->userCollection->collection->insertMany([
            [
                'userName' => 'test1',
            ],
            [
                'userName' => 'test2',
            ],
        ]);

        $insertManyResult->isAcknowledged() ?: throw new \Exception('Could not seed userCollection');
    }

    private function dropCollections(): void
    {
        $this->purchaseCollection->collection->drop();
        $this->userCollection->collection->drop();
    }
}
