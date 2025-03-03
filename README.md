# laminas-hydrator-example

This repository provides examples for the laminas-hydrator component.

- nullable Properties: see [Album#coverUrl](src/Album/Dto.php)
- Mapping property names: see [Album#coverUrl](src/Album/Dto.php) and [DtoHydratorFactory:59](src/Album/DtoHydratorFactory.php#L59)
- Dto Property: see [Album#Artist](src/Album/Dto.php)
- BackedEnumStrategy: see [Album#genre](src/Album/Dto.php) and [DtoHydratorFactory:42](src/Album/DtoHydratorFactory.php#L42)
- DateTimeImmutableStrategy: see [Album#releaseDate](src/Album/Dto.php) and [DtoHydratorFactory:46](src/Album/DtoHydratorFactory.php#L46)
- Custom strategy: see [Album#money](src/Album/Dto.php), [DtoHydratorFactory:50](src/Album/DtoHydratorFactory.php#L50) and [MoneyStrategy](src/Ampliamento/Laminas/Hydrator/Strategy/MoneyStrategy.php)
- Collection: see [Album#tracks](src/Album/Dto.php), [DtoHydratorFactory:54](src/Album/DtoHydratorFactory.php#L54) and [Track\DtoCollectionStrategy](src/Track/DtoCollectionStrategy.php)

For more information see the [official documentation](https://docs.laminas.dev/laminas-hydrator/).
