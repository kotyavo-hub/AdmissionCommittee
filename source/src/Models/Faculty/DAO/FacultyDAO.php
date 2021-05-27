<?php

namespace AC\Models\Faculty\DAO;

use AC\Models\Contest\DTO\ContestDTO;
use AC\Models\DataAccessObject;
use ParagonIE\EasyDB\EasyStatement;
use ParagonIE\EasyDB\Exception\MustBeNonEmpty;

/**
 * Класс DAO для работы с таблицей факультетов
 *
 * Class FacultyDAO
 * @package AC\Models\Faculty\DAO
 */
class FacultyDAO extends DataAccessObject
{
    protected const TABLE = 'faculty';

    /**
     * Функция для получения записей по массиву id
     *
     * @param array $ids
     * @return array
     * @throws MustBeNonEmpty
     */
    public function getByIds(array $ids): array
    {
        $statement = EasyStatement::open()->in('id IN (?*)', $ids);

        $sql = "SELECT * FROM faculty
                WHERE $statement";

        return $this->getDB()->safeQuery($sql, $statement->values());
    }

    /**
     * Функция получения записи по конкурсу
     *
     * @param ContestDTO $contestDto
     * @return array
     */
    public function getByContest(ContestDTO $contestDto): array
    {
        $statement = EasyStatement::open()->with('id = ?', $contestDto->facultyCode);

        $sql = "SELECT * FROM faculty
                WHERE $statement";

        return $this->getDB()->safeQuery($sql, $statement->values());
    }
}