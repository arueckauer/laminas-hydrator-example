<?php

declare(strict_types=1);

namespace TestDouble\User;

use LaminasHydratorExample\Address\DtoStrategy as AddressDtoStrategy;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use LaminasHydratorExample\User\DtoHydratorFactory as Implementation;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use TestDouble\Address\DtoStrategyFactory as AddressDtoStrategyFactory;
use TestDouble\InMemoryContainer;

final readonly class DtoHydratorFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function invoke(): AutoInstantiatingReflectionHydrator
    {
        $container = new InMemoryContainer();
        $container->setService(AddressDtoStrategy::class, AddressDtoStrategyFactory::invoke());

        return (new Implementation())($container);
    }
}
