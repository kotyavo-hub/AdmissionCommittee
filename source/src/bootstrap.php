<?php

use AC\Config\RoutesConfig;
use AC\Service\Http\Request;
use AC\Service\Http\Router;
use DI\Container;

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions(include __DIR__.'/Config/container.php');
$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(true);
$container = $containerBuilder->build();

$router = new Router(
    new RoutesConfig(),
    new Request(),
    $container
);

try {
    $router->dispatchRoute();
} catch (Exception $ex) {
    $router->sendErrorResponse($ex->getMessage(), $ex->getCode());
} catch (Throwable $ex) {
    $router->sendErrorResponse($ex->getMessage(), 500);
}