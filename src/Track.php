<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

readonly class Track
{
    public function __construct(
        public int $number,
        public string $title,
        public int $length,
    ) {
    }
}
