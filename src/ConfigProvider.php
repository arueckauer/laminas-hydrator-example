<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

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
            'invokables' => [
                NullableMoneyStrategy::class => NullableMoneyStrategy::class,
            ],
            'factories'  => [
                Literature\BookHydratorInterface::class => Literature\BookHydratorFactory::class,
                Music\AlbumHydratorInterface::class     => Music\AlbumHydratorFactory::class,
            ],
        ];
    }
}
