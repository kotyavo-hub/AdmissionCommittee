<?php

namespace AC\Models\Faculty\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class FacultyDTO extends DataTransferObject
{
    public int $id;

    public string $name;
}