<?php

declare(strict_types=1);

namespace LaminasHydratorExampleTest\User;

use LaminasHydratorExample\Address\Dto as AddressDto;
use LaminasHydratorExample\User\Dto as UserDto;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use TestDouble\User\DtoStrategyFactory;

use function assert;
use function dirname;
use function is_file;
use function is_readable;

final class HydratorTest extends TestCase
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function test_extract(): void
    {
        $user = new UserDto(
            'John Doe',
            'john.doe@example.com',
            new AddressDto(
                '123 Main St',
                'Anytown',
                '12345',
                'USA',
            ),
        );

        $dtoStrategy = DtoStrategyFactory::invoke();

        $actual = $dtoStrategy->extract($user);

        self::assertSame($this->data(), $actual);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function test_hydrate(): void
    {
        $expectedAddress = new AddressDto(
            '123 Main St',
            'Anytown',
            '12345',
            'USA',
        );
        $expected        = new UserDto(
            'John Doe',
            'john.doe@example.com',
            $expectedAddress
        );

        $dtoStrategy = DtoStrategyFactory::invoke();

        /** @psalm-var UserDto $actual */
        $actual = $dtoStrategy->hydrate($this->data(), []);

        self::assertEquals($expected, $actual);
        self::assertEquals($expectedAddress, $actual->address);
    }

    /**
     * @psalm-return array<string, string>
     */
    private function data(): array
    {
        $file = dirname(__DIR__, 2) . '/asset/user/row.php';
        assert(is_file($file) && is_readable($file));

        /** @psalm-var array<string, string> $row */
        $row = require $file;

        return $row;
    }
}
