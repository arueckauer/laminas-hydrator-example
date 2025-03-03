<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

use DateTimeImmutable;

final readonly class Album
{
    public function __construct(
        public Artist $artist,
        public string $name,
        public Genre $genre,
        public DateTimeImmutable $releaseDate,
        public Money $recommendedRetailPrice,
        public TrackCollection $tracks,
        public ?string $coverUrl,
    ) {
    }
}
