<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

use InvalidArgumentException;
use Laminas\Hydrator\Strategy\StrategyInterface;

use function count;
use function number_format;
use function preg_match;
use function sprintf;

readonly class NullableMoneyStrategy implements StrategyInterface
{
    /**
     * @inheritDoc
     */
    public function extract($value, ?object $object = null): ?string
    {
        if (! $value instanceof Money) {
            return null;
        }

        return sprintf(
            '%s %s',
            $value->currency,
            number_format($value->amount, 2, '.', ''),
        );
    }

    /**
     * @inheritDoc
     */
    public function hydrate($value, ?array $data): ?Money
    {
        if ($value instanceof Money || $value === null) {
            return $value;
        }

        $matches = [];
        preg_match('/^([A-Z]{3})\s([0-9]+\.[0-9]{2})$/', (string) $value, $matches);

        if (count($matches) !== 3) {
            throw new InvalidArgumentException('Invalid money format');
        }

        return new Money($matches[1], (float) $matches[2]);
    }
}
