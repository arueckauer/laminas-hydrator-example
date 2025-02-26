<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Ampliamento\Laminas\Hydrator;

use Laminas\Hydrator\ReflectionHydrator;
use ReflectionClass;
use ReflectionException;

/**
 * @template T of object
 */
final readonly class AutoInstantiatingReflectionHydrator
{
    /**
     * @psalm-param class-string<T> $targetClass
     */
    public function __construct(
        private ReflectionHydrator $reflectionHydrator,
        private string $targetClass,
    ) {
    }

    public function extract(object $object): array
    {
        return $this->reflectionHydrator->extract($object);
    }

    /**
     * @psalm-param array<string, mixed> $data
     * @psalm-return T
     * @throws ReflectionException
     */
    public function hydrate(array $data): object
    {
        $reflectionClass = new ReflectionClass($this->targetClass);

        return $this->reflectionHydrator->hydrate($data, $reflectionClass->newInstanceWithoutConstructor());
    }
}
