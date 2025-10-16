<?php

declare(strict_types=1);

namespace TestDouble\Address;

use LaminasHydratorExample\Address\DtoHydratorInterface;
use LaminasHydratorExample\Address\DtoStrategy;
use LaminasHydratorExample\Address\DtoStrategyFactory as Implementation;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
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

        return (new Implementation())($container);
    }
}
