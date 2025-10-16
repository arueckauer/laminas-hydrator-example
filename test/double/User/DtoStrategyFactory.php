<?php

declare(strict_types=1);

namespace TestDouble\User;

use LaminasHydratorExample\Address\DtoStrategy as AddressDtoStrategy;
use LaminasHydratorExample\User\DtoHydratorInterface;
use LaminasHydratorExample\User\DtoStrategy;
use LaminasHydratorExample\User\DtoStrategyFactory as Implementation;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use TestDouble\Address\DtoStrategyFactory as AddressDtoStrategyFactory;
use TestDouble\InMemoryContainer;

final readonly class DtoStrategyFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function invoke(): DtoStrategy
    {
        $container = new InMemoryContainer();
        $container->setService(DtoHydratorInterface::class, DtoHydratorFactory::invoke());
        $container->setService(AddressDtoStrategy::class, AddressDtoStrategyFactory::invoke());

        return (new Implementation())($container);
    }
}
