<?php

declare(strict_types=1);

namespace LaminasHydratorExampleTest\Literature;

use JsonException;
use LaminasHydratorExample\Literature\Book;
use LaminasHydratorExample\Literature\BookHydratorFactory;
use LaminasHydratorExample\Literature\Repository;
use LaminasHydratorExample\Money;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use ReflectionException;

use function dirname;
use function file_get_contents;

class RepositoryTest extends TestCase
{
    /**
     * @throws Exception
     * @throws JsonException
     * @throws ReflectionException
     */
    public function test_fetchBookByIsbn(): void
    {
        $expected = new Book(
            'Little Women - Betty und ihre Schwestern',
            'Louisa May Alcott',
            '2022-01-28',
            new Money('CHF', 18.0),
            '978-87-28-16883-7',
            'Roman',
        );

        $payload = file_get_contents(
            dirname(__DIR__, 2) . '/asset/literature/book/little-women+-+betty-und-ihre-schwestern.json'
        );

        $contents = $this->createMock(StreamInterface::class);
        $contents
            ->expects(self::once())
            ->method('getContents')
            ->willReturn($payload);

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($contents);

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient
            ->expects(self::once())
            ->method('sendRequest')
            ->willReturn($response);

        $bookHydrator = (new BookHydratorFactory())(
            $this->createStub(ContainerInterface::class)
        );

        $repository = new Repository(
            $httpClient,
            $bookHydrator,
        );

        $actual = $repository->fetchBookByIsbn('978-87-28-16883-7');

        self::assertEquals($expected, $actual);
    }
}
