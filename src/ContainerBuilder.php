<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio;

use Psr\Container\ContainerInterface;

class ContainerBuilder
{
    public function __construct(private readonly \DI\ContainerBuilder $builder = new \DI\ContainerBuilder())
    {
        $this->builder->addDefinitions(__DIR__ . '/../config.php');
    }

    public function build(AppEnvironment $appEnvironment): ContainerInterface
    {
        match ($appEnvironment) {
            AppEnvironment::PROD => $this->withDefinitionCacheAndCompilation(),
            AppEnvironment::TEST, AppEnvironment::DEV => $this->withDevDefinition()
        };

        return $this->builder->build();
    }

    private function withDefinitionCacheAndCompilation(): void
    {
        $this->builder->enableDefinitionCache();
        $this->builder->enableCompilation(__DIR__ . '/../var/container');
    }

    private function withDevDefinition(): void
    {
        $this->builder->addDefinitions(__DIR__ . '/../config-dev.php');
    }
}