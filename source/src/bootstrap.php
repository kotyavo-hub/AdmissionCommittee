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
    var_dump($ex);
    //$router->sendErrorResponse($ex);
} catch (Throwable $ex) {
    var_dump($ex);
    //$router->sendErrorResponse($ex);
}