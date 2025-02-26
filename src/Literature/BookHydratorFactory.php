<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Literature;

use Laminas\Hydrator\ReflectionHydrator;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use LaminasHydratorExample\NullableMoneyStrategy;
use Psr\Container\ContainerInterface;

use function assert;

class BookHydratorFactory
{
    public function __invoke(ContainerInterface $container): AutoInstantiatingReflectionHydrator
    {
        $nullableMoneyStrategy = $container->get(NullableMoneyStrategy::class);
        assert($nullableMoneyStrategy instanceof NullableMoneyStrategy);

        $reflectionHydrator = new ReflectionHydrator();
        $reflectionHydrator->addStrategy(
            'price',
            $nullableMoneyStrategy,
        );

        return new AutoInstantiatingReflectionHydrator(
            $reflectionHydrator,
            Book::class,
        );
    }
}
