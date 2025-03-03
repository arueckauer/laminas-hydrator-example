<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Album;

use DateTimeImmutable;
use LaminasHydratorExample\Artist\Dto as ArtistDto;
use LaminasHydratorExample\Genre;
use LaminasHydratorExample\Money;
use LaminasHydratorExample\Track\DtoCollection;

final readonly class Dto
{
    public function __construct(
        public ArtistDto $artist,
        public string $name,
        public Genre $genre,
        public DateTimeImmutable $releaseDate,
        public Money $recommendedRetailPrice,
        public DtoCollection $tracks,
        public ?string $coverUrl,
    ) {
    }
}
