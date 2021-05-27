<?php declare(strict_types=1);

namespace AC\Models\Dictionary\Enum;

use MyCLabs\Enum\Enum;

/**
 * Класс-перечисление таблиц справочников
 *
 * Class DictionaryTableEnum
 * @method static self EXAMS
 * @method static self GENDERS
 * @method static self CITIZEN
 * @method static self IDENTITY_DOC_TYPES
 * @method static self COUNTRIES
 * @method static self LANGUAGES
 * @method static self PRESTARTS
 * @method static self PREEM_RIGHTS_TYPES
 * @method static self INDIVID_ACHIEVS_TYPES
 * @method static self SPEC_RIGHTS_TYPES
 * @package AC\Models\Dictionary\Enum
 */
class DictionaryTableEnum extends Enum
{
    public const EXAMS                 = 'exams';
    public const GENDERS               = 'genders';
    public const CITIZEN               = 'сitizen';
    public const IDENTITY_DOC_TYPES    = 'identityDocTypes';
    public const COUNTRIES             = 'countries';
    public const LANGUAGES             = 'languages';
    public const PRESTARTS             = 'prestarts';
    public const PREEM_RIGHTS_TYPES    = 'preemRightsTypes';
    public const INDIVID_ACHIEVS_TYPES = 'individAchievsTypes';
    public const SPEC_RIGHTS_TYPES     = 'specRightsTypes';

}