<?php

namespace AC\Service\User;

use AC\Models\User\DTO\UserDTO;
use AC\Models\User\Enum\UserRoleEnum;
use AC\Service\Http\Request;

/**
 * Class UserManager
 * @package AC\Service\User
 */
class UserManager
{

    /**
     * Функция проверяет авторизацию текущего пользователя
     *
     * @param $user
     * @return bool
     */
    public function checkAuth(?UserDTO $user): bool
    {
        return (bool)($user);
    }

    /**
     * Получает пользователя из сессии объекта Request
     * @param Request $request
     * @return UserDTO|null
     */
    public function getUserFromRequest(Request $request): ?UserDTO
    {
        $user = $request->getParamFromSessionVar('User');
        $user = ($user instanceof UserDTO) ? $user : null;
        return $user;
    }

    /**
     * Функция проверяет есть ли доступ у текущего пользователя
     *
     * @param UserDTO|null $user
     * @param UserRoleEnum $role
     * @return bool
     */
    public function checkUserPermission(?UserDTO $user, UserRoleEnum $role): bool
    {
        if ($user->role === UserRoleEnum::ADMIN) {
            return true;
        }

        return ($user->role === $role->getValue());
    }

    /**
     * Функция для генерации случайного пароля
     *
     * @return string
     */
    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}