<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest;

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\ContainerBuilder;
use Iterator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/** @covers \Froepstorf\Cryptoportfolio\ContainerBuilder */
class ContainerBuilderTest extends TestCase
{
    private \DI\ContainerBuilder|MockObject $diContainerBuilderMock;

    private ContainerInterface|MockObject $containerMock;

    private readonly ContainerBuilder $containerBuilder;

    protected function setUp(): void
    {
        $this->containerMock = $this->createMock(ContainerInterface::class);
        $this->diContainerBuilderMock = $this->createMock(\DI\ContainerBuilder::class);

        $this->containerBuilder = new ContainerBuilder($this->diContainerBuilderMock);
    }

    /**
     * @dataProvider deployedEnvsProvider()
     */
    public function testBuildsWithCacheAndCompilationForDeployedEnvironments(AppEnvironment $appEnvironment): void
    {
        $this->diContainerBuilderMock->expects($this->once())
            ->method('enableCompilation');

        $this->diContainerBuilderMock->expects($this->once())
            ->method('enableDefinitionCache');

        $this->diContainerBuilderMock->expects($this->once())
            ->method('build')
            ->willReturn($this->containerMock);

        $this->containerBuilder->build($appEnvironment);
    }

    /**
     * @dataProvider localEnvsProvider()
     */
    public function testBuildsContainerWithLocalEnvs(AppEnvironment $appEnvironment): void
    {
        $this->diContainerBuilderMock->expects($this->never())
            ->method('enableDefinitionCache');

        $this->diContainerBuilderMock->expects($this->never())
            ->method('enableCompilation');

        $this->diContainerBuilderMock->expects($this->once())
            ->method('build')
            ->willReturn($this->containerMock);

        $this->containerBuilder->build($appEnvironment);
    }

    protected function deployedEnvsProvider(): Iterator
    {
        yield [AppEnvironment::PROD];
    }

    protected function localEnvsProvider(): Iterator
    {
        yield [AppEnvironment::DEV];
        yield [AppEnvironment::TEST];
    }
}
