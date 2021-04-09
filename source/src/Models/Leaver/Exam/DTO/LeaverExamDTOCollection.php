<?php

namespace AC\Models\Leaver\Exam\DTO;

use Spatie\DataTransferObject\DataTransferObjectCollection;

class LeaverExamDTOCollection extends DataTransferObjectCollection
{
    public function current(): LeaverExamDTO
    {
        return parent::current();
    }
}