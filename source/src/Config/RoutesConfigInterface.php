<?php declare(strict_types=1);

namespace AC\Config;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;
use Generator;

interface RoutesConfigInterface
{
    /**
     * @return Generator|RouteGroupItem[]
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     */
    public function createRouteGroupItems(): Generator;
}