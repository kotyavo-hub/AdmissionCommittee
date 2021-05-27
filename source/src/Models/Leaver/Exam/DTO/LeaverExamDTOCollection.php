<?php

namespace AC\Models\Leaver\Exam\DTO;

use AC\Models\Leaver\DTO\LeaverDTO;
use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * Класс коллекция DTO для работы с данными о экзаменах
 *
 * Class LeaverExamDTOCollection
 * @see LeaverDTO
 * @see LeaverExamDTO
 * @package AC\Models\Leaver\Exam\DTO
 */
class LeaverExamDTOCollection extends DataTransferObjectCollection
{
    public function current(): LeaverExamDTO
    {
        return parent::current();
    }

    public static function create(array $data): LeaverExamDTOCollection
    {
        return new static(LeaverExamDTO::arrayOf($data));
    }
}