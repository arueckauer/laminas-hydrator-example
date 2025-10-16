<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Track;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

use function count;

/**
 * @template TKey of array-key
 * @template TValue
 * @implements ArrayAccess<int, Dto>
 * @implements IteratorAggregate<int, Dto>
 */
final readonly class DtoCollection implements ArrayAccess, Countable, IteratorAggregate
{
    /** @var Dto[] */
    private array $tracks;

    public function __construct(Dto ...$data)
    {
        $this->tracks = $data;
    }

    #[\Override]
    public function count(): int
    {
        return count($this->tracks);
    }

    #[\Override]
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->tracks[$offset]);
    }

    #[\Override]
    public function offsetGet(mixed $offset): mixed
    {
        return $this->tracks[$offset];
    }

    #[\Override]
    public function offsetSet(mixed $offset, mixed $value): void
    {
    }

    #[\Override]
    public function offsetUnset(mixed $offset): void
    {
    }

    #[\Override]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->tracks);
    }
}
