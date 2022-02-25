<?php

use Froepstorf\Cryptoportfolio\ContainerBuilder;
use Froepstorf\Cryptoportfolio\EnvironmentReader;
use Froepstorf\Cryptoportfolio\Persistence\User\Collection\UserCollection;

require __DIR__ . '/../vendor/autoload.php';

$container = (new ContainerBuilder())->build(EnvironmentReader::getAppEnvironment());

/** @var UserCollection $userCollection */
$userCollection = $container->get(UserCollection::class);


$userCollection->collection->drop();
$result = $userCollection->collection->insertMany([
    [
        'userName' => 'test1'
    ],
    [
        'userName' => 'test2'
    ]
]);

print_r($result->isAcknowledged());
