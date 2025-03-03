<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

final readonly class Money
{
    public function __construct(
        public string $currency,
        public float $amount,
    ) {
    }
}
