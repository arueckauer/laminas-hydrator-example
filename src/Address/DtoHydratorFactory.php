<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Address;

use Laminas\Hydrator\NamingStrategy\MapNamingStrategy;
use Laminas\Hydrator\ReflectionHydrator;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;

final class DtoHydratorFactory
{
    public function __invoke(): AutoInstantiatingReflectionHydrator
    {
        $reflectionHydrator = new ReflectionHydrator();
        $reflectionHydrator->setNamingStrategy(MapNamingStrategy::createFromHydrationMap(
            [
                'address_street'      => 'street',
                'address_city'        => 'city',
                'address_postal_code' => 'postalCode',
                'address_country'     => 'country',
            ],
        ));

        return new AutoInstantiatingReflectionHydrator(
            $reflectionHydrator,
            Dto::class,
        );
    }
}
