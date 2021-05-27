<?php

namespace AC\Models\Contest\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Leaver\DTO\LeaverDTO;
use AC\Models\Specialty\DTO\SpecialtyDTO;
use ParagonIE\EasyDB\EasyStatement;
use ParagonIE\EasyDB\Exception\MustBeNonEmpty;

/**
 * Класс для работы работы с таблицей направлений и их конкурсов
 *
 * Class ContestDAO
 * @package AC\Models\Contest\DAO
 */
class ContestDAO extends DataAccessObject
{
    /**
     * Функция получает доступные конкурсы
     *
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

    public function getById(int $id): ?array
    {
        $statement = EasyStatement::open()->with('id = ?', $id);

        $sql = "SELECT * FROM contests
                WHERE $statement";

        return $this->getDB()->safeQuery($sql, $statement->values());
    }
}