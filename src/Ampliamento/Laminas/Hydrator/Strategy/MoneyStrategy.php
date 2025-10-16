<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Ampliamento\Laminas\Hydrator\Strategy;

use InvalidArgumentException;
use Laminas\Hydrator\Strategy\StrategyInterface;
use LaminasHydratorExample\Money;

use function count;
use function number_format;
use function preg_match;
use function sprintf;

final readonly class MoneyStrategy implements StrategyInterface
{
    /**
     * @inheritDoc
     */
    #[\Override]
    public function extract($value, ?object $object = null): string
    {
        if (! $value instanceof Money) {
                throw new InvalidArgumentException('Invalid money value');
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
    #[\Override]
    public function hydrate($value, ?array $data): Money
    {
        if ($value instanceof Money) {
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
