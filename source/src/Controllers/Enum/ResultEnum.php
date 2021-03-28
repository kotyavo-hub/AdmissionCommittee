<?php declare(strict_types=1);

namespace AC\Controllers\Enum;

use MyCLabs\Enum\Enum;

class ResultEnum extends Enum
{
    public const STATUS = 'status';
    public const ERRORS = 'errors';
    public const DATA   = 'data';
}