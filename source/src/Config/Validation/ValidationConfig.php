<?php

namespace AC\Config\Validation;

use AC\Config\Config;
use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;

class ValidationConfig extends Config
{
    const CONFIG_NAME = 'Validation';
    const CONFIG_FILE_NAME = 'validation.php';

    /**
     * @var array $config
     */
    private $config;

    /**
     * @param ValidationConfigKeys $key
     * @return array
     * @throws InvalidConfigException
     * @throws ConfigFileNotFoundException
     */
    public function getValidationRules(ValidationConfigKeys $key): array
    {
        if($this->config === null){
            $this->getConfig();
        }
        if (!is_array($this->config)) {
            throw InvalidConfigException::create(self::CONFIG_NAME);
        }

        return $this->config[$key->getKey()][ValidationConfigKeys::RULES_KEY];
    }

    /**
     * @param ValidationConfigKeys $key
     * @return mixed
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     */
    public function getValidationMessages(ValidationConfigKeys $key)
    {
        if($this->config === null){
            $this->getConfig();
        }
        if (!is_array($this->config)) {
            throw InvalidConfigException::create(static::CONFIG_NAME);
        }
        return $this->config[$key->getKey()][ValidationConfigKeys::MESSAGES_KEY];
    }

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