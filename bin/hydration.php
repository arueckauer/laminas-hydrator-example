<?php

declare(strict_types=1);

use Laminas\Hydrator\ReflectionHydrator;
use LaminasHydratorExample\Album;
use LaminasHydratorExample\AlbumHydratorInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Output\ConsoleOutput;

require_once dirname(__DIR__) . '/vendor/autoload.php';

(static function (): void {
    $container = require dirname(__DIR__) . '/config/container.php';
    assert($container instanceof ContainerInterface);

    $output = new ConsoleOutput();

    $dataPath  = dirname(__DIR__) . '/test/asset/album/';
    $filenames = scandir($dataPath);

    if ($filenames === false) {
        $output->writeln('<error>Unable to read data path</error>');
        return;
    }

    $albumFiles = array_filter(
        $filenames,
        static fn (string $file): bool => pathinfo($file, PATHINFO_EXTENSION) === 'json'
    );

    foreach ($albumFiles as $albumFile) {
        $inputJson = file_get_contents($dataPath . $albumFile);

        if ($inputJson === false) {
            $output->writeln(sprintf('<error>Unable to read file: %s</error>', $albumFile));
            continue;
        }

        /** @var array<string, mixed> $inputArray */
        $inputArray = json_decode(
            $inputJson,
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $reflectionHydrator = $container->get(AlbumHydratorInterface::class);
        assert($reflectionHydrator instanceof ReflectionHydrator);

        $reflectionClass = new ReflectionClass(Album::class);
        $instance        = $reflectionClass->newInstanceWithoutConstructor();

        $album = $reflectionHydrator->hydrate($inputArray, $instance);
        assert($album instanceof Album);

        $output->writeln(sprintf(
            '<info>%s (%s)</info>',
            $album->name,
            $album->artist,
        ));

        $output->writeln('Hydrated album:');
        $output->writeln(print_r($album, true));

        $extractedDataAlbum = $reflectionHydrator->extract($album);
        $output->writeln('Extracted album (JSON):');
        $output->writeln(json_encode($extractedDataAlbum, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
        $output->writeln('');
    }
})();
