<?php

namespace AC\Config\Validation;

use MyCLabs\Enum\Enum;

/**
 * @method static self AUTHENTICATION()
 * @method static self REGISTRATION()
 * @method static self APPLYING_CONFIRM_EMAIL()
 */

final class ValidationConfigKeys extends Enum
{
    public const REGISTRATION            = 'Registration';
    public const AUTHENTICATION          = 'Authentication';
    public const RULES_KEY               = 'Rules';
    public const MESSAGES_KEY            = 'Messages';
    public const APPLYING_CONFIRM_EMAIL  = 'ConfirmEmail';
}