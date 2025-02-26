<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Literature;

use GuzzleHttp\Psr7\Request;
use JsonException;
use Laminas\Hydrator\ReflectionHydrator;
use LaminasHydratorExample\Exception\FetchFailed;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use ReflectionClass;
use ReflectionException;

use function json_decode;

use const JSON_THROW_ON_ERROR;

final readonly class Repository
{
    public function __construct(
        private ClientInterface $httpClient,
        private ReflectionHydrator $bookHydrator,
    ) {
    }

    /**
     * @throws ReflectionException
     * @throws JsonException
     */
    public function fetchBookByIsbn(string $isbn): Book
    {
        try {
            $response = $this->httpClient->sendRequest(
                new Request(
                    'GET',
                    'https://springfieldpubliclibrary.org/api/books/' . $isbn,
                ),
            );
        } catch (ClientExceptionInterface $exception) {
            throw FetchFailed::create(
                'book',
                'ISBN',
                $isbn,
                $exception
            );
        }

        /** @psalm-var array<string, mixed> $payload */
        $payload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $reflectionClass = new ReflectionClass(Book::class);

        return $this->bookHydrator->hydrate(
            $payload,
            $reflectionClass->newInstanceWithoutConstructor(),
        );
    }
}
