<?php

namespace AC\Models\Leaver\Exam\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\DataTransferObjectCollection;

class LeaverExamDTO extends DataTransferObject
{
    public ?int $id;

    public int $examId;

    public int $result;

    public int $passingLeaverTests = 0;
}