<?php declare(strict_types=1);

namespace AC\Config\Menu\Enum;

use MyCLabs\Enum\Enum;

/**
 * Класс-перечисление опций конфига меню
 *
 * Class HeaderOptionEnum
 * @package AC\Models\User\Enum
 * @method static self URL();
 * @method static self TEXT();
 * @method static self NEED_AUTH();
 * @method static self NEED_ROLE();
 */

class MenuConfigKeys extends Enum
{
    public const URL = 'url';
    public const TEXT = 'text';
    public const NEED_AUTH = 'needAuth';
    public const NEED_ROLE = 'needRole';
    public const NOT_AUTH = 'notAuth';
}