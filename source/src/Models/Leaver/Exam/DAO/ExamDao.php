<?php

namespace AC\Models\Leaver\Exam\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Leaver\DTO\LeaverDTO;
use AC\Models\Leaver\Exam\DTO\LeaverExamDTO;
use AC\Models\Leaver\Exam\DTO\LeaverExamDTOCollection;
use Exception;
use ParagonIE\EasyDB\EasyStatement;

/**
 * Класс DAO для работы с таблицей onlineLeaverExam
 *
 * Class ExamDao
 * @package AC\Models\Leaver\Exam\DAO
 */
class ExamDao extends DataAccessObject
{
    const table = 'onlineLeaverExam';

    /**
     * Функция добавляет новую запись в таблицу экзаменов и возвращает ID
     *
     * @param LeaverExamDTO $dto
     * @return int
     * @throws Exception
     */
    public function add(LeaverExamDTO $dto): int
    {
        return $this->getDB()->insertReturnId(
            $this::table,
            $dto->except('id')->toArray()
        );
    }

    /**
     * Функция добавляет несколько новых записей и возвращает их ID
     *
     * @param LeaverExamDTOCollection $collection
     * @return array
     * @throws Exception
     */
    public function addMore(LeaverExamDTOCollection $collection): array
    {
        $returnIds = [];

        foreach ($collection as $exam) {
            $this->add($exam);
        }

        return $returnIds;
    }

    /**
     * Функция получает экзамены по ID абитуриента
     *
     * @param int $id
     * @see LeaverDTO
     * @return array
     */
    public function getByLeaverId(int $id): array
    {
        $statement = EasyStatement::open()->with('leaverId = ?', $id);

        $sql = "SELECT * FROM onlineLeaverExam
                WHERE $statement";

        return $this->getDB()->safeQuery($sql, $statement->values());
    }
}