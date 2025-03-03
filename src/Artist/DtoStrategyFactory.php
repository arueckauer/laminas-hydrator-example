<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Artist;

use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;

final class DtoStrategyFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): DtoStrategy
    {
        $artistHydrator = $container->get(DtoHydratorInterface::class);
        assert($artistHydrator instanceof AutoInstantiatingReflectionHydrator);

        return new DtoStrategy(
            $artistHydrator,
        );
    }
}
