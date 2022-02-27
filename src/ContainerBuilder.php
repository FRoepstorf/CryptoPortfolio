<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio;

use Psr\Container\ContainerInterface;

class ContainerBuilder
{
    public function __construct(
        private readonly \DI\ContainerBuilder $containerBuilder = new \DI\ContainerBuilder()
    ) {
        $this->containerBuilder->addDefinitions(__DIR__ . '/../config.php');
    }

    public function build(AppEnvironment $appEnvironment): ContainerInterface
    {
        match ($appEnvironment) {
            AppEnvironment::PROD => $this->withDefinitionCacheAndCompilation(),
            AppEnvironment::TEST, AppEnvironment::DEV => $this->withDevDefinition()
        };

        return $this->containerBuilder->build();
    }

    private function withDefinitionCacheAndCompilation(): void
    {
        $this->containerBuilder->enableDefinitionCache();
        $this->containerBuilder->enableCompilation(__DIR__ . '/../var/container');
    }

    private function withDevDefinition(): void
    {
        $this->containerBuilder->addDefinitions(__DIR__ . '/../config-dev.php');
    }
}
