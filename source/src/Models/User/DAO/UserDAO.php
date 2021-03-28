<?php
namespace AC\Models\User\DAO;

use AC\Models\DataAccessObject;
use AC\Models\User\DTO\UserDTO;

class UserDAO extends DataAccessObject
{
    const table = 'users';

    public function add(UserDTO $dto): int
    {
        return $this->getDB()->insert($this::table, $dto->except('id', 'confirmEmail')->toArray());
    }

    public function existEmail(string $email): bool
    {
        return $this->getDB()->exists(
          "SELECT count(email) FROM users WHERE email = ?",
            $email
        );
    }

    public function existLogin(string $login): bool
    {
        return $this->getDB()->exists(
            "SELECT count(email) FROM users WHERE login = ?",
            $login
        );
    }

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