<?php

declare(strict_types=1);

namespace LaminasHydratorExample\User;

use Laminas\Hydrator\Strategy\StrategyInterface;
use LaminasHydratorExample\Address\Dto as AddressDto;
use LaminasHydratorExample\Address\DtoStrategy as AddressDtoStrategy;
use LaminasHydratorExample\Ampliamento\Laminas\Hydrator\AutoInstantiatingReflectionHydrator;
use Override;
use ReflectionException;

use function array_merge;
use function assert;

final readonly class DtoStrategy implements StrategyInterface
{
    public function __construct(
        private AutoInstantiatingReflectionHydrator $dtoHydrator,
        private AddressDtoStrategy $addressDtoStrategy,
    ) {
    }

    /**
     * @inheritDoc
     */
    #[Override]
    public function extract($value, ?object $object = null)
    {
        assert($value instanceof Dto);

        $data = $this->dtoHydrator->extract($value);

        /** @psalm-var array<string, string> $address */
        $address = $data['address'];
        unset($data['address']);

        return array_merge($data, $address);
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    #[Override]
    public function hydrate($value, ?array $data)
    {
        /** @psalm-var array<string, mixed> $value */
        $address = $this->addressDtoStrategy->hydrate($value, null);
        assert($address instanceof AddressDto);

        $userWithoutAddress = $this->dtoHydrator->hydrate($value);
        assert($userWithoutAddress instanceof Dto);

        return new Dto(
            $userWithoutAddress->name,
            $userWithoutAddress->email,
            $address,
        );
    }
}
