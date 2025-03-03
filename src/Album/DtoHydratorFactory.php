<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Album;

use Laminas\Hydrator\NamingStrategy\MapNamingStrategy;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Hydrator\Strategy\BackedEnumStrategy;
use Laminas\Hydrator\Strategy\DateTimeFormatterStrategy;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\Strategy\DateTimeImmutableMidnightFormatterStrategy;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\Strategy\MoneyStrategy;
use LaminasHydratorExample\Artist\DtoStrategy;
use LaminasHydratorExample\Genre;
use LaminasHydratorExample\Track\DtoCollectionStrategy;
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
        $artistStrategy = $container->get(DtoStrategy::class);
        assert($artistStrategy instanceof DtoStrategy);

        $trackCollectionStrategy = $container->get(DtoCollectionStrategy::class);
        assert($trackCollectionStrategy instanceof DtoCollectionStrategy);

        $reflectionHydrator = new ReflectionHydrator();
        $reflectionHydrator->addStrategy(
            'artist',
            $artistStrategy,
        );
        $reflectionHydrator->addStrategy(
            'genre',
            new BackedEnumStrategy(Genre::class)
        );
        $reflectionHydrator->addStrategy(
            'releaseDate',
            new DateTimeImmutableMidnightFormatterStrategy(new DateTimeFormatterStrategy('Y-m-d'))
        );
        $reflectionHydrator->addStrategy(
            'recommendedRetailPrice',
            new MoneyStrategy()
        );
        $reflectionHydrator->addStrategy(
            'tracks',
            $trackCollectionStrategy,
        );

        $reflectionHydrator->setNamingStrategy(MapNamingStrategy::createFromAsymmetricMap(
            [
                'coverUrl' => 'cover',
            ],
            [
                'cover' => 'coverUrl',
            ],
        ));

        return new AutoInstantiatingReflectionHydrator(
            $reflectionHydrator,
            Dto::class,
        );
    }
}
