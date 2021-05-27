<?php

namespace AC\Service\Mail;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Mail\MailConfig;
use AC\Config\Mail\MailConfigKeys;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Сервис-обертка для PHPMailer
 *
 * Class Mailer
 * @package AC\Service\Mail
 */
class Mailer extends PHPMailer
{
    /**
     * @var MailConfig
     */
    private $mailConfig;

    /**
     * @param MailConfig $mailConfig
     */
    public function __construct(MailConfig $mailConfig)
    {
        $this->mailConfig = $mailConfig;
        parent::__construct();
    }

    /**
     * @throws Exception
     * @throws ConfigFileNotFoundException
     */
    protected function setConfig(): void
    {
        $config = $this->mailConfig->getConfig();

        foreach ($config as $key => $value){
            switch ($key) {
                case ($key === MailConfigKeys::IS_SMTP && $value === true):
                    $this->isSMTP();
                    break;
                case MailConfigKeys::SET_FROM:
                    $this->setFrom(
                        $value[MailConfigKeys::SET_FROM_ADDRESS],
                        $value[MailConfigKeys::SET_FROM_NAME]
                    );
                    break;
                default:
                    $this->$key = $value;
            }
        }
    }

    /**
     * @param $from
     * @param $subject
     * @param $body
     * @throws ConfigFileNotFoundException
     * @throws Exception
     */
    public function sendMail($from, $subject, $body)
    {
        $this->setConfig();

        $this->addAddress($from, $from);
        $this->Subject = $subject;
        $this->Body = $body;
        $this->msgHTML($body);

        $this->send();
    }
}