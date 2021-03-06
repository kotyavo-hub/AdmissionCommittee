<?php

namespace AC\Config;

use AC\Controllers\API\ContestController;
use AC\Controllers\API\SpecialityController;
use AC\Controllers\ApplyingController;
use AC\Controllers\AuthController;
use AC\Controllers\DocumentController;
use AC\Controllers\IndexController;
use AC\Controllers\PersonalController;
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
                    RouteConfigKeys::ROUTE => '/applying/{guid:\w+}/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => ApplyingController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'applyingGet'
                ],
                [
                    RouteConfigKeys::ROUTE => '/applying/{guid:\w+}/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_POST,
                    RouteConfigKeys::CONTROLLER => ApplyingController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'applyingPost'
                ],
                [
                    RouteConfigKeys::ROUTE => '/document/{id:\d+}/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => DocumentController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'documentGet'
                ],
                [
                    RouteConfigKeys::ROUTE => '/personal/{id:\d+}/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => PersonalController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'personalGet'
                ],
                [
                    RouteConfigKeys::ROUTE => '/personal/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => PersonalController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'personalIndexGet'
                ],
                [
                    RouteConfigKeys::ROUTE => '/personal/all/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => PersonalController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'personalAllGet'
                ],
                [
                    RouteConfigKeys::ROUTE => '/exit/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_GET,
                    RouteConfigKeys::CONTROLLER => AuthController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'exitGet'
                ],
            ],
        ],
        [
            RouteConfigKeys::GROUP_BASE => '/apiV1/',
            RouteConfigKeys::GROUP_ITEMS => [
                [
                    RouteConfigKeys::ROUTE => 'speciality/specialties_available_by_leaver/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_POST,
                    RouteConfigKeys::CONTROLLER => SpecialityController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'getSpecialtiesAvailableByLeaver'
                ],
                [
                    RouteConfigKeys::ROUTE => 'contest/available_by_leaver_and_speciality/',
                    RouteConfigKeys::HTTP_METHOD => Request::METHOD_POST,
                    RouteConfigKeys::CONTROLLER => ContestController::class,
                    RouteConfigKeys::CONTROLLER_ACTION => 'getAvailableByLeaverAndSpeciality'
                ],
            ],
        ]
    ]
];