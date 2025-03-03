<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;

final class TrackCollectionStrategyFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): TrackCollectionStrategy
    {
        $trackHydrator = $container->get(TrackHydratorInterface::class);
        assert($trackHydrator instanceof AutoInstantiatingReflectionHydrator);

        return new TrackCollectionStrategy(
            $trackHydrator,
        );
    }
}
