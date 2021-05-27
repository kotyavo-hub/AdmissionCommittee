<?php declare(strict_types=1);

namespace AC\Controllers\Enum;

use AC\Models\Result\ResultDTO;
use MyCLabs\Enum\Enum;

/**
 * Класс-перечисление полей объекта Result
 * @see ResultDTO
 *
 * Class ResultEnum
 * @package AC\Controllers\Enum
 */
class ResultEnum extends Enum
{
    public const STATUS = 'status';
    public const ERRORS = 'errors';
    public const DATA   = 'data';
}