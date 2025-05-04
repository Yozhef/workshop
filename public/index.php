<?php

use App\Infrastructure\Bootstrap\DoctrineTypesBootstrap;
use App\Kernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context): Kernel {
    $kernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
    (new DoctrineTypesBootstrap())->setSerializer();

    return $kernel;
};
