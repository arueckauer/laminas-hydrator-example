<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;

final class ArtistStrategyFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ArtistStrategy
    {
        $artistHydrator = $container->get(ArtistHydratorInterface::class);
        assert($artistHydrator instanceof AutoInstantiatingReflectionHydrator);

        return new ArtistStrategy(
            $artistHydrator,
        );
    }
}
