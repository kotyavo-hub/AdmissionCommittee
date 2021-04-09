<?php

namespace AC\Models\Faculty\DAO;

use AC\Models\Contest\DTO\ContestDTO;
use AC\Models\DataAccessObject;
use AC\Models\Leaver\DTO\LeaverDTO;
use ParagonIE\EasyDB\EasyStatement;
use ParagonIE\EasyDB\Exception\MustBeNonEmpty;

class FacultyDAO extends DataAccessObject
{
    protected const TABLE = 'faculty';

    /**
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

    public function getByContest(ContestDTO $contestDto): array
    {
        $statement = EasyStatement::open()->with('id = ?', $contestDto->facultyCode);

        $sql = "SELECT * FROM faculty
                WHERE $statement";

        return $this->getDB()->safeQuery($sql, $statement->values());
    }
}