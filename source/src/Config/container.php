<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [
    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__.'/../View/');
        return new Environment($loader, []);
    },
];