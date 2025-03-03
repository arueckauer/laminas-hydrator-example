<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Track;

final readonly class Dto
{
    public function __construct(
        public int $number,
        public string $title,
        public int $length,
    ) {
    }
}
