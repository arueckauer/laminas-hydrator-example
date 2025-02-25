<?php

declare(strict_types=1);

namespace LaminasHydratorExample\Literature;

enum Genre: string
{
    case FANTASY  = 'Fantasy';
    case FICTION  = 'Fiction';
    case HORROR   = 'Horror';
    case MYSTERY  = 'Mystery';
    case ROMANCE  = 'Romance';
    case THRILLER = 'Thriller';
}
