<?php

namespace AC\Models\Faculty\DTO;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Класс DTO для работы с данными факультетов
 *
 * Class FacultyDTO
 * @package AC\Models\Faculty\DTO
 */
class FacultyDTO extends DataTransferObject
{
    public int $id;

    public string $name;
}