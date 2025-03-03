<?php

declare(strict_types=1);

namespace LaminasHydratorExampleTest;

use DateTimeImmutable;
use LaminasHydratorExample\Album;
use LaminasHydratorExample\AlbumHydratorFactory;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use LaminasHydratorExample\Genre;
use LaminasHydratorExample\Money;
use LaminasHydratorExample\Track;
use LaminasHydratorExample\TrackCollection;
use LaminasHydratorExample\TrackCollectionStrategy;
use LaminasHydratorExample\TrackCollectionStrategyFactory;
use LaminasHydratorExample\TrackHydratorFactory;
use LaminasHydratorExample\TrackHydratorInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

use function assert;
use function dirname;
use function file_get_contents;
use function json_decode;

use const JSON_THROW_ON_ERROR;

final class AlbumHydratorTest extends TestCase
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     * @throws ReflectionException
     */
    public function test_hydrate_thriller(): void
    {
        $expected = new Album(
            'Michael Jackson',
            'Thriller',
            Genre::Pop,
            new DateTimeImmutable('1982-11-29'),
            new Money('USD', 12.0),
            new TrackCollection(
                new Track(1, 'Wanna Be Startin\' Somethin\'', 363),
                new Track(2, 'Baby Be Mine', 260),
                new Track(3, 'The girl is mine', 222),
                new Track(4, 'Thriller', 358),
            ),
            'https://www.epicrecords.com/artists/michael-jackson/albums/thriller/cover',
        );

        $actual = $this->albumHydrator()->hydrate($this->data('thriller.json'));

        self::assertEquals($expected, $actual);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     * @throws ReflectionException
     */
    public function test_hydrate_wirKinderVomBahnhofSoul(): void
    {
        $expected = new Album(
            'Jan Delay',
            'Wir Kinder vom Bahnhof Soul',
            Genre::Funk,
            new DateTimeImmutable('2009-08-14'),
            new Money('EUR', 17.99),
            new TrackCollection(
                new Track(1, 'Showgeschäft', 282),
                new Track(2, 'Oh Jonny', 219),
                new Track(3, 'Ein Leben Lang', 266),
                new Track(4, 'Überdosis Fremdscham', 263),
            ),
            null,
        );

        $actual = $this->albumHydrator()->hydrate($this->data('wir-kinder-vom-bahnhof-soul.json'));

        self::assertEquals($expected, $actual);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    private function albumHydrator(): AutoInstantiatingReflectionHydrator
    {
        $trackHydrator = (new TrackHydratorFactory())($this->createStub(ContainerInterface::class));

        $containerA = $this->createMock(ContainerInterface::class);
        $containerA
            ->expects(self::once())
            ->method('get')
            ->with(TrackHydratorInterface::class)
            ->willReturn($trackHydrator);

        $trackCollectionStrategy = (new TrackCollectionStrategyFactory())($containerA);

        $containerB = $this->createMock(ContainerInterface::class);
        assert($containerB instanceof ContainerInterface);

        $containerB
            ->expects(self::once())
            ->method('get')
            ->with(TrackCollectionStrategy::class)
            ->willReturn($trackCollectionStrategy);

        return (new AlbumHydratorFactory())($containerB);
    }

    /**
     * @psalm-return array<string, mixed>
     */
    private function data(string $filename): array
    {
        $thriller = file_get_contents(dirname(__DIR__) . '/asset/album/' . $filename);
        assert($thriller !== false);

        /** @psalm-var array<string, mixed> $data */
        $data = json_decode(
            $thriller,
            true,
            JSON_THROW_ON_ERROR,
        );

        return $data;
    }
}
