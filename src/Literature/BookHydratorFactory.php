<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Literature;

use Laminas\Hydrator\ReflectionHydrator;
use LaminasHydratorExample\NullableMoneyStrategy;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;

class BookHydratorFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ReflectionHydrator
    {
        $nullableMoneyStrategy = $container->get(NullableMoneyStrategy::class);
        assert($nullableMoneyStrategy instanceof NullableMoneyStrategy);

        $reflectionHydrator = new ReflectionHydrator();

        $reflectionHydrator->addStrategy(
            'price',
            $nullableMoneyStrategy,
        );

        return $reflectionHydrator;
    }
}
