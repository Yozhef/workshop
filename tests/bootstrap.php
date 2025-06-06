<?php

declare(strict_types=1);

use App\Infrastructure\Bootstrap\DoctrineTypesBootstrap;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

putenv('APP_ENV=' . $_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = 'test');

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}

(new DoctrineTypesBootstrap())->setSerializer();
