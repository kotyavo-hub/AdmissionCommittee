<?php

namespace AC\Models\Leaver\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Leaver\DTO\LeaverDTO;
use Exception;

/**
 * Класс DAO для работы с таблицей onlineLeaver
 *
 * Class LeaverDAO
 * @package AC\Models\Leaver\DAO
 */
class LeaverDAO extends DataAccessObject
{
    const table = 'onlineLeaver';

    /**
     * Функция добавляет новую запись для работы с заявлениями
     *
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

    /**
     * Функция проверяет наличие email
     *
     * @param string $email
     * @return bool
     */
    public function existEmail(string $email): bool
    {
        return $this->getDB()->exists(
            "SELECT count(email) FROM onlineLeaver WHERE email = ?",
            $email
        );
    }

    /**
     * Функция обновляет статус email
     *
     * @param int $id
     * @return int
     */
    public function updateStatusEmail(int $id): int
    {
        return $this->getDB()->update(
            $this::table,
            ['statusEmail' => 1],
            ['id' => $id]
        );
    }

    /**
     * Функция получения записи по guid
     *
     * @param string $guid
     * @return array|mixed
     */
    public function getByGuid(string $guid)
    {
        return $this->getDB()->row(
            'SELECT * FROM onlineLeaver WHERE guid = ?',
            $guid
        );
    }

    /**
     * Функция получения записи по id
     *
     * @param int $id
     * @return array|mixed
     */
    public function getById(int $id)
    {
        return $this->getDB()->row(
            'SELECT * FROM onlineLeaver WHERE id = ?',
            $id
        );
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM onlineLeaver";

        return $this->getDB()->safeQuery($sql);
    }

    /**
     * Функция обновления после подачи заявления
     *
     * @param LeaverDTO $dto
     * @return int
     */
    public function updateByApplying(LeaverDTO $dto): int
    {
        return $this->getDB()->update(
            $this::table,
            $dto->except(
                'id',
                'passportFile',
                'educDocFile',
                'exams',
                'specRights',
                'preemRights',
                'individAchievs',
                'urov',
                'correctInfoFile',
                'specials',
                'guid',
                'email'
            )->toArray(),
            ['id' => $dto->id]
        );
    }
}