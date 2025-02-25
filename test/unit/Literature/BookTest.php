<?php

declare(strict_types=1);

namespace LaminasHydratorExampleTest\Literature;

use JsonException;
use LaminasHydratorExample\Literature\Book;
use LaminasHydratorExample\Literature\BookHydratorFactory;
use LaminasHydratorExample\Money;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;

use function dirname;
use function file_get_contents;
use function json_decode;

use const JSON_THROW_ON_ERROR;

class BookTest extends TestCase
{
    /**
     * @throws JsonException
     * @throws Exception
     * @throws ReflectionException
     */
    #[DataProvider('bookProvider')]
    public function test___construct(Book $expected, string $file): void
    {
        /** @psalm-var array<string, mixed> $payload */
        $payload = json_decode(
            file_get_contents(dirname(__DIR__, 2) . '/asset/literature/book/' . $file),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $container = $this->createStub(ContainerInterface::class);

        $bookHydrator = (new BookHydratorFactory())($container);

        $reflectionClass = new ReflectionClass(Book::class);
        $actual          = $bookHydrator->hydrate($payload, $reflectionClass->newInstanceWithoutConstructor());

        self::assertEquals($expected->title, $actual->title);
        self::assertEquals($expected->author, $actual->author);
        self::assertEquals($expected->publishedAt, $actual->publishedAt);
        self::assertEquals($expected->price, $actual->price);
        self::assertEquals($expected->isbn, $actual->isbn);
        self::assertEquals($expected->genre, $actual->genre);
    }

    public static function bookProvider(): array
    {
        return [
            'die_unendliche_geschichte' => [
                new Book(
                    'Die unendliche Geschichte',
                    'Michael Ende',
                    '1979-09-01',
                    new Money('DEM', 12.99),
                    '3-522-12800-1',
                    'Fantasy',
                ),
                'die-unendliche-geschichte.json',
            ],
            'unbekanntes_buch'          => [
                new Book(
                    null,
                    'Ghost Writer',
                    null,
                    null,
                    null,
                    null,
                ),
                'unbekanntes-buch.json',
            ],
        ];
    }
}
