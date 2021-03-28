<?php declare(strict_types=1);

namespace AC\Models\User\Enum;

use MyCLabs\Enum\Enum;

/**
 * Class UserRoleEnum
 * @package AC\Models\User\Enum
 * @method static self DEFAULT();
 * @method static self ADMIN();
 */

class UserRoleEnum extends Enum
{
    public const DEFAULT = 0;
    public const ADMIN   = 1;
}