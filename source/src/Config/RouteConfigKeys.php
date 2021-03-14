<?php declare(strict_types=1);

namespace AC\Config;

use MyCLabs\Enum\Enum;

class RouteConfigKeys extends Enum
{
    public const GROUP_ROUTES = 'groupRoutes';
    public const GROUP_BASE = 'groupBase';
    public const GROUP_ITEMS = 'groupItems';
    public const ROUTE = 'route';
    public const HTTP_METHOD = 'httpMethod';
    public const CONTROLLER = 'controller';
    public const CONTROLLER_ACTION = 'controllerAction';
}