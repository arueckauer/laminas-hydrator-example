<?php

declare(strict_types=1);

namespace LaminasHydratorExample;

/**
 * @psalm-type _Dependencies = array<string, array<string, string|array>>
 */
final class ConfigProvider
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
                Address\DtoHydratorInterface::class => Address\DtoHydratorFactory::class,
                Address\DtoStrategy::class          => Address\DtoStrategyFactory::class,
                Album\DtoHydratorInterface::class   => Album\DtoHydratorFactory::class,
                Artist\DtoHydratorInterface::class  => Artist\DtoHydratorFactory::class,
                Artist\DtoStrategy::class           => Artist\DtoStrategyFactory::class,
                Track\DtoCollectionStrategy::class  => Track\DtoCollectionStrategyFactory::class,
                Track\DtoHydratorInterface::class   => Track\DtoHydratorFactory::class,
                User\DtoHydratorInterface::class    => User\DtoHydratorFactory::class,
                User\DtoStrategy::class             => User\DtoStrategyFactory::class,
            ],
        ];
    }
}
