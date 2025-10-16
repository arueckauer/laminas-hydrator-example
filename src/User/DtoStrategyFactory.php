<?php

declare(strict_types=1);

namespace LaminasHydratorExample\User;

use LaminasHydratorExample\Address\DtoStrategy as AddressDtoStrategy;
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
        $dtoHydrator = $container->get(DtoHydratorInterface::class);
        assert($dtoHydrator instanceof AutoInstantiatingReflectionHydrator);

        $addressDtoStrategy = $container->get(AddressDtoStrategy::class);
        assert($addressDtoStrategy instanceof AddressDtoStrategy);

        return new DtoStrategy(
            $dtoHydrator,
            $addressDtoStrategy,
        );
    }
}
