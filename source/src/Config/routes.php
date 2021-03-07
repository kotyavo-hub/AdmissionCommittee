<?php

namespace AC\Config;

use AC\Controllers\Page\IndexController;
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
            ]
        ]
    ]
];