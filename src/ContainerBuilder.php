<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio;

use Psr\Container\ContainerInterface;

class ContainerBuilder
{
    public function __construct(private \DI\ContainerBuilder $builder = new \DI\ContainerBuilder())
    {
        $this->builder->addDefinitions(__DIR__ . '/../config.php');
    }

    public function build(AppEnvironment $appEnvironment): ContainerInterface
    {
        if ($appEnvironment->isProd()) {
            $this->forProd();
        }

        return $this->builder->build();
    }

    public function forProd(): void
    {
        $this->builder->enableDefinitionCache();
        $this->builder->enableCompilation(__DIR__ . '/../var/container');

    }
}