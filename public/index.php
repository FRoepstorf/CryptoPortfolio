<?php

use Froepstorf\Cryptoportfolio\AppBuilder;
use Froepstorf\Cryptoportfolio\ContainerBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require '../vendor/autoload.php';

$app = AppBuilder::build(new ContainerBuilder());

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->run();