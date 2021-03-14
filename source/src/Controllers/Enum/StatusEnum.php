<?php declare(strict_types=1);

namespace AC\Controllers\Enum;

use MyCLabs\Enum\Enum;

class StatusEnum extends Enum
{
    public const SUCCESS = 1;
    public const FAILURE = 0;
}