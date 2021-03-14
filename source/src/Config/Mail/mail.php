<?php

namespace AC\Config\Mail;

return [
    MailConfigKeys::IS_SMTP => true,
    MailConfigKeys::CHAR_SET => 'UTF-8',
    MailConfigKeys::HOST => 'ssl://smtp.gmail.com',
    MailConfigKeys::SMTP_AUTH => true,
    MailConfigKeys::SMTP_SECURE => 'ssl',
    MailConfigKeys::USERNAME => 'keevise@gmail.com',
    MailConfigKeys::PASSWORD => 'jSzTIeIu',
    MailConfigKeys::PORT => 465,
    MailConfigKeys::SET_FROM => [
        MailConfigKeys::SET_FROM_ADDRESS => 'keevise@gmail.com',
        MailConfigKeys::SET_FROM_NAME => 'Примемная коммисия',
    ]
];