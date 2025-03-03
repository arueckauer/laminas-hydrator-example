<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

use Laminas\Hydrator\NamingStrategy\MapNamingStrategy;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Hydrator\Strategy\BackedEnumStrategy;
use Laminas\Hydrator\Strategy\DateTimeFormatterStrategy;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\Strategy\DateTimeImmutableMidnightFormatterStrategy;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\Strategy\MoneyStrategy;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;

final class AlbumHydratorFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): AutoInstantiatingReflectionHydrator
    {
        $artistStrategy = $container->get(ArtistStrategy::class);
        assert($artistStrategy instanceof ArtistStrategy);

        $trackCollectionStrategy = $container->get(TrackCollectionStrategy::class);
        assert($trackCollectionStrategy instanceof TrackCollectionStrategy);

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
            Album::class,
        );
    }
}
