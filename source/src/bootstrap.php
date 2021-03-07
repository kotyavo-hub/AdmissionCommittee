<?php

use AC\Config\RoutesConfig;
use AC\Controllers\Page\IndexController;
use AC\Service\Http\Request;
use AC\Service\Http\Router;
use DI\Container;

$router = new Router(
    new RoutesConfig(),
    new Request(),
    new Container(),
    new IndexController()
);

try {
    $router->dispatchRoute();
} catch (Exception $ex) {
    $router->sendErrorResponse($ex->getMessage(), $ex->getCode());
} catch (Throwable $ex) {
    $router->sendErrorResponse($ex->getMessage(), 500);
}