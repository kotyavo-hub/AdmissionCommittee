<?php declare(strict_types=1);

namespace AC\Service\Http\Enum;

use MyCLabs\Enum\Enum;

/**
 * Класс-перечисление http ошибок
 *
 * Class HttpCodeEnum
 * @package AC\Service\Http\Enum
 * @method static self FORBIDDEN();
 * @method static self NOT_FOUND();
 */

class HttpCodeEnum extends Enum
{
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
}