<?php


namespace AC\Config\Mail;

use AC\Config\Config;
use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;

class MailConfig extends Config
{
    const CONFIG_NAME = 'mail';
    const CONFIG_FILE_NAME = 'mail.php';

    private $config;

    /**
     * @return array
     * @throws ConfigFileNotFoundException
     */
    public function getConfig(): array
    {
        if (null === $this->config) {
            $this->config = $this->readInConfigFile($this->getConfigFilePath());
        }

        return $this->config;
    }

    private function getConfigFilePath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . self::CONFIG_FILE_NAME;
    }
}