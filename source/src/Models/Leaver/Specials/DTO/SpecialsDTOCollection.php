<?php

namespace AC\Models\Leaver\Specials\DTO;

use AC\Models\Leaver\DTO\LeaverDTO;
use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * Класс коллекция DTO для хранение данных о конкурсах абитуриента
 *
 * Class SpecialsDTOCollection
 * @see LeaverDTO
 * @see SpecialsDTO
 * @package AC\Models\Leaver\Specials\DTO
 */
class SpecialsDTOCollection extends DataTransferObjectCollection
{
    public function current(): SpecialsDTO
    {
        return parent::current();
    }

    public static function create(array $data): SpecialsDTOCollection
    {
        return new static(SpecialsDTO::arrayOf($data));
    }
}