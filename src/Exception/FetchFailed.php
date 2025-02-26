<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Exception;

use RuntimeException;
use Stringable;
use Throwable;

use function sprintf;

class FetchFailed extends RuntimeException
{
    public static function create(
        string $entityName,
        string $identifier,
        float|int|Stringable|string $identifierValue,
        Throwable $exception
    ): self {
        return new self(
            sprintf(
                'Failed to fetch %s by %s "%s"',
                $entityName,
                $identifier,
                $identifierValue,
            ),
            (int) $exception->getCode(),
            $exception
        );
    }
}
