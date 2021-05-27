<?php

namespace AC\Service\Menu;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Menu\Enum\MenuConfigFilesEnum;
use AC\Config\Menu\Enum\MenuConfigKeys;
use AC\Config\Menu\MenuConfig;
use AC\Service\Http\Request;
use AC\Service\User\UserManager;

/**
 * Сервис для генерации меню
 *
 * Class MenuGenerator
 * @package AC\Service\Menu
 */
class MenuGenerator
{
    /**
     * @Inject
     * @var UserManager
     */
    private UserManager $userManager;

    /**
     * @Inject
     * @var MenuConfig
     */
    private MenuConfig $menuConfig;

    /**
     * @Inject
     * @var Request
     */
    private Request $request;

    /**
     * Функция генерирует элемент меню
     *
     * @param array $menuItem
     * @return array
     */
    public function generateLink(array $menuItem)
    {
        return [
            'url'  => $menuItem[MenuConfigKeys::URL],
            'text' => $menuItem[MenuConfigKeys::TEXT],
        ];
    }

    /**
     * Функция для генерации массива элементов меню
     *
     * @param MenuConfigFilesEnum $menuConfigFile
     * @return array
     * @throws ConfigFileNotFoundException
     */
    public function generateMenu(MenuConfigFilesEnum $menuConfigFile): array
    {
        $headerConfig = $this->menuConfig->getConfig($menuConfigFile);
        $user = $this->userManager->getUserFromRequest($this->request);

        $result = [];

        foreach ($headerConfig as $menuItem) {
            if (
                !$menuItem[MenuConfigKeys::URL] ||
                !$menuItem[MenuConfigKeys::TEXT]
            ) {
                continue;
            } elseif (
                $menuItem[MenuConfigKeys::NOT_AUTH] &&
                $this->userManager->checkAuth($user)
            ) {
                continue;
            } elseif (
                $menuItem[MenuConfigKeys::NEED_AUTH] &&
                !$this->userManager->checkAuth($user)
            ) {
                continue;
            } elseif (
                $menuItem[MenuConfigKeys::NEED_ROLE] &&
                !$this->userManager->checkUserPermission(
                    $user, $menuItem[MenuConfigKeys::NEED_ROLE]
                )
            ) {
                continue;
            }

            $result[] = $this->generateLink($menuItem);
        }

        return $result;
    }
}