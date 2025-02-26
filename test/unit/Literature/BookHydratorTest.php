<?php

declare(strict_types=1);

namespace LaminasHydratorExampleTest\Literature;

use Error;
use JsonException;
use LaminasHydratorExample\Literature\Book;
use LaminasHydratorExample\Literature\BookHydratorFactory;
use LaminasHydratorExample\Money;
use LaminasHydratorExample\NullableMoneyStrategy;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ReflectionException;

use function dirname;
use function file_get_contents;
use function json_decode;

use const JSON_THROW_ON_ERROR;

class BookHydratorTest extends TestCase
{
    /**
     * @throws Exception
     * @throws JsonException
     * @throws ReflectionException
     */
    #[DataProvider('extractProvider')]
    public function test_extract(array $expected, string $file): void
    {
        $bookHydrator = (new BookHydratorFactory())($this->container());

        $book = $bookHydrator->hydrate(
            $this->getFileAsPayload($file),
        );

        $actual = $bookHydrator->extract($book);

        self::assertEquals($expected, $actual);
    }

    /**
     * @throws Exception
     * @throws JsonException
     * @throws ReflectionException
     */
    public function test_extract_incompletePayload(): void
    {
        $bookHydrator = (new BookHydratorFactory())($this->container());

        $book = $bookHydrator->hydrate(
            $this->getFileAsPayload('unvollständiger-payload.json'),
        );

        // phpcs:ignore Generic.Files.LineLength.TooLong
        $message = 'Typed property LaminasHydratorExample\Literature\Book::$title must not be accessed before initialization';

        $this->expectException(Error::class);
        $this->expectExceptionMessage($message);

        $bookHydrator->extract($book);
    }

    /**
     * @throws Exception
     * @throws JsonException
     * @throws ReflectionException
     */
    #[DataProvider('hydrateProvider')]
    public function test_hydrate(Book $expected, string $file): void
    {
        $bookHydrator = (new BookHydratorFactory())($this->container());

        $actual = $bookHydrator->hydrate(
            $this->getFileAsPayload($file),
        );

        self::assertEquals($expected->title, $actual->title);
        self::assertEquals($expected->author, $actual->author);
        self::assertEquals($expected->publishedAt, $actual->publishedAt);
        self::assertEquals($expected->price, $actual->price);
        self::assertEquals($expected->isbn, $actual->isbn);
        self::assertEquals($expected->genre, $actual->genre);
    }

    /**
     * @throws Exception
     * @throws JsonException
     * @throws ReflectionException
     */
    public function test_hydrate_incompletePayload(): void
    {
        $bookHydrator = (new BookHydratorFactory())($this->container());

        $actual = $bookHydrator->hydrate(
            $this->getFileAsPayload('unvollständiger-payload.json'),
        );

        self::assertEquals('Arno Nym', $actual->author);
        self::assertEquals(['author' => 'Arno Nym'], (array) $actual);
    }

    public static function extractProvider(): array
    {
        return [
            'die_unendliche_geschichte' => [
                [
                    'title'       => 'Die unendliche Geschichte',
                    'author'      => 'Michael Ende',
                    'publishedAt' => '1979-09-01',
                    'price'       => 'DEM 12.99',
                    'isbn'        => '3-522-12800-1',
                    'genre'       => 'Fantasy',
                ],
                'die-unendliche-geschichte.json',
            ],
            'unbekanntes_buch'          => [
                [
                    'title'       => null,
                    'author'      => 'Ghost Writer',
                    'publishedAt' => null,
                    'price'       => null,
                    'isbn'        => null,
                    'genre'       => null,
                ],
                'unbekanntes-buch.json',
            ],
        ];
    }

    public static function hydrateProvider(): array
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

    /**
     * @psalm-return array<string, mixed>
     * @throws JsonException
     */
    private function getFileAsPayload(string $file): array
    {
        /** @psalm-var array<string, mixed> $payload */
        $payload = json_decode(
            file_get_contents(dirname(__DIR__, 2) . '/asset/literature/book/' . $file),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return $payload;
    }

    /**
     * @throws Exception
     */
    private function container(): ContainerInterface
    {
        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects(self::once())
            ->method('get')
            ->with(NullableMoneyStrategy::class)
            ->willReturn(new NullableMoneyStrategy());

        return $container;
    }
}
