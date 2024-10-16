<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Hydrator\Strategy\BackedEnumStrategy;
use Laminas\Hydrator\Strategy\CollectionStrategy;
use Laminas\Hydrator\Strategy\DateTimeFormatterStrategy;
use Laminas\Hydrator\Strategy\DateTimeImmutableFormatterStrategy;
use Psr\Container\ContainerInterface;

class AlbumHydratorFactory
{
    public function __invoke(ContainerInterface $container): ReflectionHydrator
    {
        $reflectionHydrator = new ReflectionHydrator();
        $reflectionHydrator->addStrategy(
            'genre',
            new BackedEnumStrategy(Genre::class)
        );
        $reflectionHydrator->addStrategy(
            'releaseDate',
            new DateTimeImmutableFormatterStrategy(new DateTimeFormatterStrategy('Y-m-d'))
        );
        $reflectionHydrator->addStrategy(
            'recommendedRetailPrice',
            new MoneyStrategy()
        );
        $reflectionHydrator->addStrategy(
            'tracks',
            new CollectionStrategy(new ReflectionHydrator(), Track::class),
        );

        return $reflectionHydrator;
    }
}
