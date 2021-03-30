<?php declare(strict_types=1);

namespace AC\Config\Dictionaries\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self EXAMS_PATH
 * @method static self GENDERS_PATH
 * @method static self CITIZEN_PATH
 * @method static self IDENTITY_DOC_TYPES_PATH
 * @method static self COUNTRIES_PATH
 * @method static self LANGUAGES_PATH
 */

class DictionaryEnum extends Enum
{
    protected const XML_PATH = __DIR__.'/../Xml/';

    public const EXAMS_PATH              = self::XML_PATH.'Exams.xml';
    public const GENDERS_PATH            = self::XML_PATH.'Genders.xml';
    public const CITIZEN_PATH            = self::XML_PATH.'Citizen.xml';
    public const COUNTRIES_PATH          = self::XML_PATH.'Countries.xml';
    public const IDENTITY_DOC_TYPES_PATH = self::XML_PATH.'IdentityDocTypes.xml';
    public const LANGUAGES_PATH          = self::XML_PATH.'Languages.xml';

}