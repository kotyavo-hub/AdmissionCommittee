<?php

use AC\Config\Menu\Enum\MenuConfigKeys;

return [
    [
        MenuConfigKeys::URL => '/applying/',
        MenuConfigKeys::TEXT => 'Подача заявления',
        MenuConfigKeys::NOT_AUTH => true,
    ],
    [
        MenuConfigKeys::URL => '', // /registration/
        MenuConfigKeys::TEXT => 'Регистрация',
        MenuConfigKeys::NOT_AUTH => true,
    ],
    [
        MenuConfigKeys::URL => '/login/',
        MenuConfigKeys::TEXT => 'Вход',
        MenuConfigKeys::NOT_AUTH => true,
    ],
    [
        MenuConfigKeys::URL => '/personal/',
        MenuConfigKeys::TEXT => 'Личное дело',
        MenuConfigKeys::NEED_ROLE => \AC\Models\User\Enum\UserRoleEnum::LEAVER(),
    ],
    [
        MenuConfigKeys::URL => '/personal/all/',
        MenuConfigKeys::TEXT => 'Личные дела',
        MenuConfigKeys::NEED_ROLE => \AC\Models\User\Enum\UserRoleEnum::INSPECTOR(),
    ],
    [
        MenuConfigKeys::URL => '/exit/',
        MenuConfigKeys::TEXT => 'Выход',
        MenuConfigKeys::NEED_AUTH => true,
    ],
];