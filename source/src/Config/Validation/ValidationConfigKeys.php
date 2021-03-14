<?php

namespace AC\Config\Validation;

use MyCLabs\Enum\Enum;

/** @method static self REGISTRATION() */

final class ValidationConfigKeys extends Enum
{
    public const REGISTRATION = 'Registration';
    public const RULES_KEY    = 'Rules';
    public const MESSAGES_KEY = 'Messages';
}