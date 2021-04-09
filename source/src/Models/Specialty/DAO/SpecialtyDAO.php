<?php

namespace AC\Models\Specialty\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Leaver\DTO\LeaverDTO;
use ParagonIE\EasyDB\EasyStatement;
use ParagonIE\EasyDB\Exception\MustBeNonEmpty;

class SpecialtyDAO extends DataAccessObject
{
    protected const CONTESTS_TABLE = 'contests';

    /**
     * @param LeaverDTO $leaverDto
     * @return array
     * @throws MustBeNonEmpty
     */
    public function getAvailableByLeaver(LeaverDTO $leaverDto): array
    {
        $leaverExams = array_column($leaverDto->exams->toArray(), 'examId');

        $statement = EasyStatement::open()
            ->group()
                ->in('exam1 IN (?*)', $leaverExams)
                ->andIn('exam2 IN (?*)', $leaverExams)
                ->andIn('exam3 IN (?*)', $leaverExams)
            ->andGroup()
                ->with('urov = ?', $leaverDto->urov)
            ->endGroup();

        $sql = "SELECT specialityCode, speciality FROM contests
                WHERE $statement
                GROUP BY specialityCode, speciality";

        return $this->getDB()->safeQuery($sql, $statement->values());
    }
}