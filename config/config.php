<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;
use LaminasHydratorExample\ConfigProvider;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),
    ConfigProvider::class,
]);

return $aggregator->getMergedConfig();
