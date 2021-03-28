<?php declare(strict_types=1);

namespace AC\Controllers\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self SUCCESS
 * @method static self FAILURE
 */

class StatusEnum extends Enum
{
    public const SUCCESS = 1;
    public const FAILURE = 0;
}