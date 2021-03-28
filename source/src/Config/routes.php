<?php

namespace AC\Config;

use AC\Controllers\ApplyingController;
use AC\Controllers\AuthController;
use AC\Controllers\IndexController;
use AC\Controllers\RegistrationController;
use AC\Service\Http\Request;

return [
    RouteConfigKeys::GROUP_ROUTES => [
        [
            RouteConfigKeys::GROUP_BASE => '',
            RouteConfigKeys::GROUP_ITEMS => [
                [
                    RouteConfigKeys::ROUTE => '/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => IndexController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'render'
                ],
                [
                    RouteConfigKeys::ROUTE => '/registration/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => RegistrationController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'registrationGet'
                ],
                [
                    RouteConfigKeys::ROUTE => '/registration/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_POST,
                    RouteConfigKeys::CONTROLLER => RegistrationController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'registrationPost'
                ],
                [
                    RouteConfigKeys::ROUTE => '/confirm_email/{emailHash:\w+}/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => RegistrationController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'confirmEmailGet'
                ],
                [
                    RouteConfigKeys::ROUTE => '/login/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => AuthController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'loginGet'
                ],
                [
                    RouteConfigKeys::ROUTE => '/login/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_POST,
                    RouteConfigKeys::CONTROLLER => AuthController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'loginPost'
                ],
                [
                    RouteConfigKeys::ROUTE => '/applying/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => ApplyingController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'indexGet'
                ],
                [
                    RouteConfigKeys::ROUTE => '/applying/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_POST,
                    RouteConfigKeys::CONTROLLER => ApplyingController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'indexPost'
                ],
                [
                    RouteConfigKeys::ROUTE => '/exit/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => AuthController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'exitGet'
                ],
            ],
        ],
    ]
];