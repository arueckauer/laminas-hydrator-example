<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Track;

use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;

final class DtoCollectionStrategyFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): DtoCollectionStrategy
    {
        $trackHydrator = $container->get(DtoHydratorInterface::class);
        assert($trackHydrator instanceof AutoInstantiatingReflectionHydrator);

        return new DtoCollectionStrategy(
            $trackHydrator,
        );
    }
}
