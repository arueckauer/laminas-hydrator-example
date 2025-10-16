<?php

declare(strict_types=1);

namespace LaminasHydratorExample\User;

use Laminas\Hydrator\ReflectionHydrator;
use LaminasHydratorExample\Address\DtoStrategy as AddressDtoStrategy;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;

final class DtoHydratorFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): AutoInstantiatingReflectionHydrator
    {
        $addressDtoStrategy = $container->get(AddressDtoStrategy::class);
        assert($addressDtoStrategy instanceof AddressDtoStrategy);

        $reflectionHydrator = new ReflectionHydrator();
        $reflectionHydrator->addStrategy(
            'address',
            $addressDtoStrategy,
        );

        return new AutoInstantiatingReflectionHydrator(
            $reflectionHydrator,
            Dto::class,
        );
    }
}
