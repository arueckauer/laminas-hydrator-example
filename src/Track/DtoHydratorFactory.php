<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Track;

use Laminas\Hydrator\ReflectionHydrator;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use Psr\Container\ContainerInterface;

final class DtoHydratorFactory
{
    public function __invoke(ContainerInterface $container): AutoInstantiatingReflectionHydrator
    {
        return new AutoInstantiatingReflectionHydrator(
            new ReflectionHydrator(),
            Dto::class,
        );
    }
}
