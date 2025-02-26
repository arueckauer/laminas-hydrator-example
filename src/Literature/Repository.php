<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Literature;

use GuzzleHttp\Psr7\Request;
use JsonException;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use LaminasHydratorExample\Exception\FetchFailed;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use ReflectionException;

use function assert;
use function json_decode;

use const JSON_THROW_ON_ERROR;

final readonly class Repository
{
    public function __construct(
        private ClientInterface $httpClient,
        private AutoInstantiatingReflectionHydrator $bookHydrator,
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

        $book = $this->bookHydrator->hydrate($payload);
        assert($book instanceof Book);

        return $book;
    }
}
