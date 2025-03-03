<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;
use LaminasHydratorExample\ConfigProvider;

$realPath = realpath(__DIR__);
assert(is_string($realPath));

$aggregator = new ConfigAggregator([
    new PhpFileProvider($realPath . '/autoload/{{,*.}global,{,*.}local}.php'),
    ConfigProvider::class,
]);

return $aggregator->getMergedConfig();
