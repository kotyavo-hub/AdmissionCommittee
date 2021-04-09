<?php

namespace AC\Models\Contest\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Leaver\DTO\LeaverDTO;
use AC\Models\Specialty\DTO\SpecialtyDTO;
use ParagonIE\EasyDB\EasyStatement;
use ParagonIE\EasyDB\Exception\MustBeNonEmpty;

class ContestDAO extends DataAccessObject
{
    /**
     * @param LeaverDTO $leaverDto
     * @param SpecialtyDTO $specialtyDto
     * @return array|bool|int|object
     * @throws MustBeNonEmpty
     */
    public function getByLeaverAndSection(LeaverDTO $leaverDto, SpecialtyDTO $specialtyDto)
    {
        $leaverExams = array_column($leaverDto->exams->toArray(), 'examId');

        $statement = EasyStatement::open()
            ->group()
                ->in('exam1 IN (?*)', $leaverExams)
                ->andIn('exam2 IN (?*)', $leaverExams)
                ->andIn('exam3 IN (?*)', $leaverExams)
            ->andGroup()
                ->with('urov = ?', $leaverDto->urov)
                ->with('specialityCode = ?', $specialtyDto->code)
            ->endGroup();

        $sql = "SELECT * FROM contests
                WHERE $statement";

        return $this->getDB()->safeQuery($sql, $statement->values());
    }
}