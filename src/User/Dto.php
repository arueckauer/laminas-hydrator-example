<?php

declare(strict_types=1);

namespace LaminasHydratorExample\User;

use LaminasHydratorExample\Address\Dto as AddressDto;

final readonly class Dto
{
    public function __construct(
        public string $name,
        public string $email,
        public AddressDto $address,
    ) {
    }
}
