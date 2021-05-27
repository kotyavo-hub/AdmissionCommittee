<?php declare(strict_types=1);

namespace AC\Controllers\Enum;

use AC\Models\Result\ResultDTO;
use MyCLabs\Enum\Enum;

/**
 * Класс-перечисление статусов для Result
 * @see ResultDTO
 *
 * Class StatusEnum
 * @method static self SUCCESS
 * @method static self FAILURE
 * @package AC\Controllers\Enum
 */
class StatusEnum extends Enum
{
    public const SUCCESS = 1;
    public const FAILURE = 0;
}