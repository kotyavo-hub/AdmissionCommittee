<?php declare(strict_types=1);

namespace AC\Models\Dictionary\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self EXAMS
 * @method static self GENDERS
 * @method static self CITIZEN
 * @method static self IDENTITY_DOC_TYPES
 * @method static self COUNTRIES
 * @method static self LANGUAGES
 * @method static self PRESTARTS
 */
class DictionaryTableEnum extends Enum
{
    public const EXAMS              = 'exams';
    public const GENDERS            = 'genders';
    public const CITIZEN            = 'сitizen';
    public const IDENTITY_DOC_TYPES = 'identityDocTypes';
    public const COUNTRIES          = 'countries';
    public const LANGUAGES          = 'languages';
    public const PRESTARTS          = 'prestarts';

}