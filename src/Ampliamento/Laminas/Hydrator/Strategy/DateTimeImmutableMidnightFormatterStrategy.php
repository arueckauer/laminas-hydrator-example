<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Ampliamento\Laminas\Hydrator\Strategy;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Laminas\Hydrator\Strategy\DateTimeFormatterStrategy;
use Laminas\Hydrator\Strategy\Exception\InvalidArgumentException;
use Laminas\Hydrator\Strategy\StrategyInterface;

final readonly class DateTimeImmutableMidnightFormatterStrategy implements StrategyInterface
{
    public function __construct(
        private DateTimeFormatterStrategy $dateTimeStrategy,
    ) {
    }

    /**
     * {@inheritDoc}
     *
     * Converts to date time string
     *
     * @param mixed|DateTimeInterface $value
     * @return mixed|string If a non-DateTimeInterface $value is provided, it
     *     will be returned unmodified; otherwise, it will be extracted to a
     *     string.
     */
    public function extract($value, ?object $object = null)
    {
        return $this->dateTimeStrategy->extract($value, $object);
    }

    /**
     * Converts date time string to DateTimeImmutable instance for injecting to object
     *
     * {@inheritDoc}
     *
     * @param mixed|string $value
     * @return mixed|DateTimeImmutable
     * @throws InvalidArgumentException If $value is not null, not a
     *     string, nor a DateTimeInterface.
     */
    public function hydrate($value, ?array $data = null)
    {
        if ($value instanceof DateTimeImmutable) {
            return $value;
        }

        /** @psalm-var mixed|DateTimeInterface $hydrated */
        $hydrated = $this->dateTimeStrategy->hydrate($value, $data);

        if ($hydrated instanceof DateTime) {
            return DateTimeImmutable::createFromMutable($hydrated->setTime(0, 0, 0));
        }

        return $hydrated ? : $value;
    }
}
