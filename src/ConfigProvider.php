<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

use LaminasHydratorExample\Music\AlbumHydratorFactory;
use LaminasHydratorExample\Music\AlbumHydratorInterface;

/**
 * @psalm-type _Dependencies = array<string, array<string, string|array>>
 */
class ConfigProvider
{
    /**
     * @psalm-return array<_Dependencies>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * @psalm-return _Dependencies
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                AlbumHydratorInterface::class => AlbumHydratorFactory::class,
            ],
        ];
    }
}
