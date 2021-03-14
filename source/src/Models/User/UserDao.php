<?php
namespace AC\Models\User;

use AC\Models\DataAccessObject;

class UserDao extends DataAccessObject
{
    const table = 'users';

    public function add(string $login, string $email, string $emailHash, string $hashPassword, int $role = 0): int
    {
        return $this->getDB()->insert($this::table, [
            'login' => $login,
            'password' => $hashPassword,
            'email' => $email,
            'emailHash' => $emailHash,
            'role' => $role
        ]);
    }

    public function existEmail(string $email): bool
    {
        return $this->getDB()->exists(
          "SELECT count(email) FROM users WHERE email = ?",
            [$email]
        );
    }

    public function confirmEmail(string $emailHash): int
    {
        return $this->getDB()->update(
            $this::table,
            ['confirmEmail' => 1],
            ['emailHash' => $emailHash]
        );
    }
}