<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Track;

use Laminas\Hydrator\Strategy\StrategyInterface;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use LaminasHydratorExample\Exception\InvalidArgument;
use ReflectionException;

use function array_map;
use function assert;
use function is_array;
use function iterator_to_array;

final readonly class DtoCollectionStrategy implements StrategyInterface
{
    public function __construct(
        private AutoInstantiatingReflectionHydrator $trackHydrator,
    ) {
    }

    /**
     * @inheritDoc
     * @throws InvalidArgument
     */
    public function extract($value, ?object $object = null)
    {
        if (! is_array($value)) {
            throw new InvalidArgument('First argument of ' . __METHOD__ . ' must be an array');
        }

        return array_map(
            fn (Dto $track) => $this->trackHydrator->extract($track),
            iterator_to_array($value)
        );
    }

    /**
     * @inheritDoc
     * @throws InvalidArgument
     * @throws ReflectionException
     */
    public function hydrate($value, ?array $data)
    {
        if (! is_array($value)) {
            throw new InvalidArgument('First argument of ' . __METHOD__ . ' must be an array');
        }

        $tracks = array_map(
            /** @psalm-param array<string, mixed> $data */
            function (array $data): Dto {
                $track = $this->trackHydrator->hydrate($data);
                assert($track instanceof Dto);

                return $track;
            },
            $value
        );

        return new DtoCollection(...$tracks);
    }
}
