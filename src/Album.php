<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

use DateTimeImmutable;

readonly class Album
{
    /**
     * @param array<array-key, Track> $tracks
     */
    public function __construct(
        public string $artist,
        public string $name,
        public Genre $genre,
        public DateTimeImmutable $releaseDate,
        public Money $recommendedRetailPrice,
        public array $tracks,
    ) {
    }
}
