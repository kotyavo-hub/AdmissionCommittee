<?php

namespace AC\Models\File\DAO;

use AC\Models\DataAccessObject;
use AC\Models\File\DTO\FileDTO;
use Exception;
use ParagonIE\EasyDB\EasyStatement;

/**
 * Класс DAO для работы с таблицей файлов
 *
 * Class FileDAO
 * @package AC\Models\File\DAO
 */
class FileDAO extends DataAccessObject
{
    protected const TABLE = 'files';

    /**
     * Функция добавляет новый файл в таблицу
     *
     * @param FileDTO $dto
     * @return int
     * @throws Exception
     */
    public function add(FileDTO $dto): int
    {
        return $this->getDB()->insertReturnId(
            $this::TABLE,
            $dto->except('id')->toArray()
        );
    }

    /**
     * Функция получает файл из таблицы по его ID
     *
     * @param int $id
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        return $this->getDB()->row(
            'SELECT * FROM files WHERE id = ?',
            $id
        );
    }
}