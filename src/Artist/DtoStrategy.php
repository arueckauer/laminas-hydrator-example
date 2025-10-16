<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Artist;

use Laminas\Hydrator\Strategy\StrategyInterface;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use LaminasHydratorExample\Exception\InvalidArgument;
use Override;
use ReflectionException;

use function is_array;

final readonly class DtoStrategy implements StrategyInterface
{
    public function __construct(
        private AutoInstantiatingReflectionHydrator $artistHydrator,
    ) {
    }

    /**
     * @inheritDoc
     */
    #[Override]
    public function extract($value, ?object $object = null)
    {
        if (! $value instanceof Dto) {
            throw new InvalidArgument('First argument of ' . __METHOD__ . ' must be an instance of ' . Dto::class);
        }

        return $this->artistHydrator->extract($value);
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    #[Override]
    public function hydrate($value, ?array $data)
    {
        if (! is_array($value)) {
            throw new InvalidArgument('First argument of ' . __METHOD__ . ' must be an array');
        }

        /** @psalm-var array<string, mixed> $value */
        return $this->artistHydrator->hydrate($value);
    }
}
