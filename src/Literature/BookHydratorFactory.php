<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Literature;

use Laminas\Hydrator\ReflectionHydrator;
use LaminasHydratorExample\NullableMoneyStrategy;
use Psr\Container\ContainerInterface;

class BookHydratorFactory
{
    public function __invoke(ContainerInterface $container): ReflectionHydrator
    {
        $reflectionHydrator = new ReflectionHydrator();

        $reflectionHydrator->addStrategy(
            'price',
            new NullableMoneyStrategy(),
        );

        return $reflectionHydrator;
    }
}
