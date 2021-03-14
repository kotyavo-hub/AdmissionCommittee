<?php declare(strict_types=1);

namespace AC\Config\Mail;

use MyCLabs\Enum\Enum;

class MailConfigKeys extends Enum
{
    public const IS_SMTP          = 'IsSMTP';
    public const CHAR_SET         = 'CharSet';
    public const HOST             = 'Host';
    public const SMTP_AUTH        = 'SMTPAuth';
    public const SMTP_SECURE      = 'SMTPSecure';
    public const USERNAME         = 'Username';
    public const PASSWORD         = 'Password';
    public const PORT             = 'Port';
    public const SET_FROM         = 'setFrom';
    public const SET_FROM_ADDRESS = 'setFromAddress';
    public const SET_FROM_NAME    = 'setFromName';

}