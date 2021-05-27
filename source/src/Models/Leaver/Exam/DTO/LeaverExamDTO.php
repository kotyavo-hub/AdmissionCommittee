<?php

namespace AC\Models\Leaver\Exam\DTO;

use AC\Models\Leaver\DTO\LeaverDTO;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Класс DTO для работы с данными о экзамене в заявлении
 *
 * Class LeaverExamDTO
 * @see LeaverDTO
 * @package AC\Models\Leaver\Exam\DTO
 */
class LeaverExamDTO extends DataTransferObject
{
    public ?int $id;

    public ?int $leaverId;

    public int $examId;

    public int $result;

    public int $passingLeaverTests = 0;
}