<?php
namespace AC\Models\Leaver\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Leaver\DTO\LeaverDTO;
use Exception;

class LeaverDAO extends DataAccessObject
{
    const table = 'onlineLeaver';

    /**
     * @param LeaverDTO $dto
     * @return int
     * @throws Exception
     */
    public function addNewLeaver(LeaverDTO $dto): int
    {
        return $this->getDB()->insertReturnId(
            $this::table,
            $dto->only('email', 'guid')->toArray()
        );
    }

    public function existEmail(string $email): bool
    {
        return $this->getDB()->exists(
            "SELECT count(email) FROM onlineLeaver WHERE email = ?",
            $email
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
}