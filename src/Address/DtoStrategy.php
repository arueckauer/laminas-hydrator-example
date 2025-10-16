<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Address;

use Laminas\Hydrator\Strategy\StrategyInterface;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use Override;
use ReflectionException;

use function assert;

final readonly class DtoStrategy implements StrategyInterface
{
    public function __construct(
        private AutoInstantiatingReflectionHydrator $dtoHydrator,
    ) {
    }

    /**
     * @inheritDoc
     */
    #[Override]
    public function extract($value, ?object $object = null)
    {
        assert($value instanceof Dto);

        return $this->dtoHydrator->extract($value);
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    #[Override]
    public function hydrate($value, ?array $data)
    {
        /** @psalm-var array<string, mixed> $value */
        return $this->dtoHydrator->hydrate($value);
    }
}
