<?php

declare(strict_types=1);

namespace TestDouble;

use Override;
use Psr\Container\ContainerInterface;
use RuntimeException;

use function array_key_exists;
use function sprintf;

/**
 * A PSR Container stub. Useful for testing factories without excessive mocking
 */
final class InMemoryContainer implements ContainerInterface
{
    /** @var array<string, mixed> */
    public array $services = [];

    public function setService(string $name, mixed $service): void
    {
        $this->services[$name] = $service;
    }

    #[Override]
    public function get(string $id): mixed
    {
        if (! $this->has($id)) {
            throw new RuntimeException(sprintf('Service not found "%s"', $id));
        }

        return $this->services[$id];
    }

    #[Override]
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }
}
