<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Address;

final readonly class Dto
{
    public function __construct(
        public string $street,
        public string $city,
        public string $postalCode,
        public string $country,
    ) {
    }
}
