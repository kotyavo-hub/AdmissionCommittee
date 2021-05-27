<?php


namespace AC\Config\Menu;

use AC\Config\Config;
use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Menu\Enum\MenuConfigFilesEnum;

/**
 * Конфигурационный класс для получения файлов-конфигов для меню
 *
 * Class MenuConfig
 * @package AC\Config\Menu
 */
class MenuConfig extends Config
{
    /**
     * @param MenuConfigFilesEnum $file
     * @return array
     * @throws ConfigFileNotFoundException
     */
    public function getConfig(MenuConfigFilesEnum $file): array
    {
        return $this->readInConfigFile($this->getConfigFilePath($file));
    }

    private function getConfigFilePath(MenuConfigFilesEnum $file): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'Files/' .$file;
    }
}