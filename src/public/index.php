<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use Infra\Router\Router;

$containerBuilder = new ContainerBuilder();
$dependencies = require __DIR__ . '/../config/dependencies.php';
$dependencies($containerBuilder);

$container = $containerBuilder->build();

$routes = require __DIR__ . '/../routes/api.php';

$router = new Router($container, $routes);
$router->dispatch();