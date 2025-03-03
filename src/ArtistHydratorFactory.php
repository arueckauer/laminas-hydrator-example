<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

use Laminas\Hydrator\ReflectionHydrator;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use Psr\Container\ContainerInterface;

final class ArtistHydratorFactory
{
    public function __invoke(ContainerInterface $container): AutoInstantiatingReflectionHydrator
    {
        return new AutoInstantiatingReflectionHydrator(
            new ReflectionHydrator(),
            Artist::class,
        );
    }
}
