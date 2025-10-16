<?php

declare(strict_types=1);

namespace TestDouble\Address;

use LaminasHydratorExample\Address\DtoHydratorFactory as Implementation;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;

final readonly class DtoHydratorFactory
{
    public static function invoke(): AutoInstantiatingReflectionHydrator
    {
        return (new Implementation())();
    }
}
