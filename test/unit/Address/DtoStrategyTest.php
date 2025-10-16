<?php

declare(strict_types=1);

namespace LaminasHydratorExampleTest\Address;

use LaminasHydratorExample\Address\Dto;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use TestDouble\Address\DtoStrategyFactory;

use function assert;
use function dirname;
use function is_file;
use function is_readable;

final class DtoStrategyTest extends TestCase
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function test_extract(): void
    {
        $actual = (DtoStrategyFactory::invoke())->extract(new Dto(
            '123 Main St',
            'Anytown',
            '12345',
            'USA',
        ));

        self::assertSame($this->data(), $actual);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function test_hydrate(): void
    {
        $expected       = new Dto(
            $street     = '123 Main St',
            $city       = 'Anytown',
            $postalCode = '12345',
            $country    = 'USA',
        );

        /** @psalm-var Dto $actual */
        $actual = (DtoStrategyFactory::invoke())->hydrate($this->data(), []);

        self::assertEquals($expected, $actual);
        self::assertSame($street, $actual->street);
        self::assertSame($city, $actual->city);
        self::assertSame($postalCode, $actual->postalCode);
        self::assertSame($country, $actual->country);
    }

    /**
     * @psalm-return array<string, string>
     */
    private function data(): array
    {
        $file = dirname(__DIR__, 2) . '/asset/address/row.php';
        assert(is_file($file) && is_readable($file));

        /** @psalm-var array<string, string> $row */
        $row = require $file;

        return $row;
    }
}
