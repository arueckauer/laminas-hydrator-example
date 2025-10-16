<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Address;

use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;

final readonly class DtoStrategyFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): DtoStrategy
    {
        $dtoHydrator = $container->get(DtoHydratorInterface::class);
        assert($dtoHydrator instanceof AutoInstantiatingReflectionHydrator);

        return new DtoStrategy(
            $dtoHydrator,
        );
    }
}
