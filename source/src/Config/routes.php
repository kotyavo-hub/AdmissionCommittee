<?php

namespace AC\Config;

use AC\Controllers\Page\IndexPageController;
use AC\Controllers\Page\RegistrationPageController;
use AC\Service\Http\Request;
use AC\Service\Http\Router;

return [
    RouteConfigKeys::GROUP_ROUTES => [
        [
            RouteConfigKeys::GROUP_BASE => '',
            RouteConfigKeys::GROUP_ITEMS => [
                [
                    RouteConfigKeys::ROUTE => '/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => IndexPageController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'render'
                ],
                [
                    RouteConfigKeys::ROUTE => '/registration/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => RegistrationPageController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'render'
                ],
                [
                    RouteConfigKeys::ROUTE => '/registration/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_POST,
                    RouteConfigKeys::CONTROLLER => RegistrationPageController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'registrationRender'
                ],
            ],
        ],
    ]
];