<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

final readonly class Artist
{
    public function __construct(
        public string $name,
        public ?string $artistName,
    ) {
    }
}
