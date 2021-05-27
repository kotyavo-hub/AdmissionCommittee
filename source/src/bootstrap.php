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

function rRestructuringFilesArray(
    &$arrayForFill, $currentKey, $currentMixedValue, $fileDescriptionParam
) {
    if (is_array($currentMixedValue)) {
        foreach ($currentMixedValue as $nameKey => $mixedValue) {
            rRestructuringFilesArray($arrayForFill[$currentKey],
                $nameKey,
                $mixedValue,
                $fileDescriptionParam);
        }
    } else {
        $arrayForFill[$currentKey][$fileDescriptionParam] = $currentMixedValue;
    }
}

$arrayForFill = array();

foreach ($_FILES as $firstNameKey => $arFileDescriptions) {
    foreach ($arFileDescriptions as $fileDescriptionParam => $mixedValue) {
        rRestructuringFilesArray($arrayForFill,
            $firstNameKey,
            $_FILES[$firstNameKey][$fileDescriptionParam],
            $fileDescriptionParam);
    }
}

$_FILES = $arrayForFill;

try {
    $router->dispatchRoute();
} catch (Exception $ex) {
    echo '<pre>';
    var_dump($ex->getMessage().'|'.$ex->getFile().'|'.$ex->getLine());
    echo '</pre>';
    //$router->sendErrorResponse($ex);
} catch (Throwable $ex) {
    echo '<pre>';
    var_dump($ex->getMessage().'|'.$ex->getFile().'|'.$ex->getLine());
    echo '</pre>';
    //$router->sendErrorResponse($ex);
}