<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

/**
 * @psalm-type _Dependencies = array<string, array<string, string|array>>
 */
final class ConfigProvider
{
    /**
     * @psalm-return array<_Dependencies>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * @psalm-return _Dependencies
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                AlbumHydratorInterface::class  => AlbumHydratorFactory::class,
                ArtistHydratorInterface::class => ArtistHydratorFactory::class,
                ArtistStrategy::class          => ArtistStrategyFactory::class,
                TrackCollectionStrategy::class => TrackCollectionStrategyFactory::class,
                TrackHydratorInterface::class  => TrackHydratorFactory::class,
            ],
        ];
    }
}
