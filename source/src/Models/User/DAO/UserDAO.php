<?php
namespace AC\Models\User\DAO;

use AC\Models\DataAccessObject;
use AC\Models\User\DTO\UserDTO;

/**
 * Класс DAO для работы с таблицей users
 *
 * Class UserDAO
 * @package AC\Models\User\DAO
 */
class UserDAO extends DataAccessObject
{
    const table = 'users';

    /**
     * Функция добавления новго пользователя
     *
     * @param UserDTO $dto
     * @return int
     */
    public function add(UserDTO $dto): int
    {
        return $this->getDB()->insert($this::table, $dto->except('id', 'confirmEmail')->toArray());
    }

    /**
     * Функция для проверки существования email
     *
     * @param string $email
     * @return bool
     */
    public function existEmail(string $email): bool
    {
        return $this->getDB()->exists(
          "SELECT count(email) FROM users WHERE email = ?",
            $email
        );
    }

    /**
     * Функция для проверки существования логина
     *
     * @param string $login
     * @return bool
     */
    public function existLogin(string $login): bool
    {
        return $this->getDB()->exists(
            "SELECT count(email) FROM users WHERE login = ?",
            $login
        );
    }

    /**
     * Функция для обновления статуса подтверждения email
     *
     * @param string $emailHash
     * @return int
     */
    public function updateConfirmEmail(string $emailHash): int
    {
        return $this->getDB()->update(
            $this::table,
            ['confirmEmail' => 1],
            ['emailHash' => $emailHash]
        );
    }

    public function getByLogin(string $login)
    {
        return $this->getDB()->row(
            'SELECT * FROM users WHERE login = ?',
            $login
        );
    }
}