<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\Intl\IntlExtension;

return [
    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__.'/../View/');
        $environment = new Environment($loader, []);
        $environment->addExtension(new IntlExtension());
        return new Environment($loader, []);
    },
];