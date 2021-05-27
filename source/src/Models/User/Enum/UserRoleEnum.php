<?php declare(strict_types=1);

namespace AC\Models\User\Enum;

use MyCLabs\Enum\Enum;

/**
 * Класс-перечисление ролей пользователей
 *
 * Class UserRoleEnum
 * @package AC\Models\User\Enum
 * @method static self DEFAULT();
 * @method static self ADMIN();
 * @method static self INSPECTOR();
 * @method static self LEAVER();
 */

class UserRoleEnum extends Enum
{
    public const DEFAULT_USER = 0;
    public const ADMIN   = 1;
    public const INSPECTOR = 2;
    public const LEAVER = 3;
}