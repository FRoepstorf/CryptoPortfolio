<?php

use Froepstorf\Cryptoportfolio\AppBuilder;
use Froepstorf\Cryptoportfolio\ContainerBuilder;

require '../vendor/autoload.php';

$app = AppBuilder::build(new ContainerBuilder());

$app->run();