<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Artist;

final readonly class Dto
{
    public function __construct(
        public string $name,
        public ?string $artistName,
    ) {
    }
}
