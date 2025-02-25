<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Literature;

use LaminasHydratorExample\Money;

readonly class Book
{
    public function __construct(
        public ?string $title,
        public string $author,
        /**
         * @todo Implement a MidnightDateTimeImmutableFormatterStrategy and change property type to DateTimeImmutable
         */
        public ?string $publishedAt,
        public ?Money $price,
        public ?string $isbn,
        /**
         * @todo Implement a NullableBackedEnumStrategy and change property type to Genre
         */
        public ?string $genre,
    ) {
    }
}
