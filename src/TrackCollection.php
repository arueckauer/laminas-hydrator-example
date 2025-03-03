<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

use function count;

/**
 * @template TKey of array-key
 * @template TValue
 * @implements ArrayAccess<int, Track>
 * @implements IteratorAggregate<int, Track>
 */
final readonly class TrackCollection implements ArrayAccess, Countable, IteratorAggregate
{
    /** @var Track[] */
    private array $tracks;

    public function __construct(Track ...$data)
    {
        $this->tracks = $data;
    }

    public function count(): int
    {
        return count($this->tracks);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->tracks[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->tracks[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
    }

    public function offsetUnset(mixed $offset): void
    {
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->tracks);
    }
}
