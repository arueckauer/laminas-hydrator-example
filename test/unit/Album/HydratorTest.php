<?php

declare(strict_types=1);

namespace LaminasHydratorExampleTest\Album;

use DateTimeImmutable;
use LaminasHydratorExample\Album\Dto as AlbumDto;
use LaminasHydratorExample\Album\DtoHydratorFactory as AlbumDtoHydratorFactory;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use LaminasHydratorExample\Artist\Dto as ArtistDto;
use LaminasHydratorExample\Artist\DtoHydratorFactory as ArtistDtoHydratorFactory;
use LaminasHydratorExample\Artist\DtoHydratorInterface as ArtistDtoHydratorInterface;
use LaminasHydratorExample\Artist\DtoStrategy as ArtistDtoStrategy;
use LaminasHydratorExample\Artist\DtoStrategyFactory as ArtistDtoStrategyFactory;
use LaminasHydratorExample\Genre;
use LaminasHydratorExample\Money;
use LaminasHydratorExample\Track\Dto as TrackDto;
use LaminasHydratorExample\Track\DtoCollection as TrackDtoCollection;
use LaminasHydratorExample\Track\DtoCollectionStrategy as TrackDtoCollectionStrategy;
use LaminasHydratorExample\Track\DtoCollectionStrategyFactory as TrackDtoCollectionStrategyFactory;
use LaminasHydratorExample\Track\DtoHydratorFactory as TrackDtoHydratorFactory;
use LaminasHydratorExample\Track\DtoHydratorInterface as TrackDtoHydratorInterface;
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

final class HydratorTest extends TestCase
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     * @throws ReflectionException
     */
    public function test_hydrate_thriller(): void
    {
        $expected = new AlbumDto(
            new ArtistDto('Michael Jackson', null),
            'Thriller',
            Genre::Pop,
            new DateTimeImmutable('1982-11-29'),
            new Money('USD', 12.0),
            new TrackDtoCollection(
                new TrackDto(1, 'Wanna Be Startin\' Somethin\'', 363),
                new TrackDto(2, 'Baby Be Mine', 260),
                new TrackDto(3, 'The girl is mine', 222),
                new TrackDto(4, 'Thriller', 358),
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
        $expected = new AlbumDto(
            new ArtistDto('Jan Philipp Eißfeldt', 'Jan Delay'),
            'Wir Kinder vom Bahnhof Soul',
            Genre::Funk,
            new DateTimeImmutable('2009-08-14'),
            new Money('EUR', 17.99),
            new TrackDtoCollection(
                new TrackDto(1, 'Showgeschäft', 282),
                new TrackDto(2, 'Oh Jonny', 219),
                new TrackDto(3, 'Ein Leben Lang', 266),
                new TrackDto(4, 'Überdosis Fremdscham', 263),
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
        $containerStub = $this->createStub(ContainerInterface::class);

        $trackHydrator = (new TrackDtoHydratorFactory())($containerStub);

        $containerA = $this->createMock(ContainerInterface::class);
        $containerA
            ->expects(self::once())
            ->method('get')
            ->with(TrackDtoHydratorInterface::class)
            ->willReturn($trackHydrator);

        $trackCollectionStrategy = (new TrackDtoCollectionStrategyFactory())($containerA);

        $artistHydrator = (new ArtistDtoHydratorFactory())($containerStub);

        $containerB = $this->createMock(ContainerInterface::class);
        $containerB
            ->expects(self::once())
            ->method('get')
            ->with(ArtistDtoHydratorInterface::class)
            ->willReturn($artistHydrator);

        $artistStrategy = (new ArtistDtoStrategyFactory())($containerB);

        $containerC = $this->createMock(ContainerInterface::class);
        $containerC
            ->expects(self::exactly(2))
            ->method('get')
            ->willReturnCallback(fn(string $serviceName) => match ($serviceName) {
                    ArtistDtoStrategy::class => $artistStrategy,
                    TrackDtoCollectionStrategy::class => $trackCollectionStrategy,
            });

        return (new AlbumDtoHydratorFactory())($containerC);
    }

    /**
     * @psalm-return array<string, mixed>
     */
    private function data(string $filename): array
    {
        $thriller = file_get_contents(dirname(__DIR__, 2) . '/asset/album/' . $filename);
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
