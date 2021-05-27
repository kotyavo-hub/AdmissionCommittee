<?php

namespace AC\Models\Leaver\DTO;

use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * Класс коллекция DTO для работы с данными о абитуриентах
 *
 * Class LeaverDTOCollection
 * @see LeaverDTO
 * @package AC\Models\Leaver\DTO
 */
class LeaverDTOCollection extends DataTransferObjectCollection
{
    public function current(): LeaverDTO
    {
        return parent::current();
    }

    public static function create(array $data): LeaverDTOCollection
    {
        return new static(LeaverDTO::arrayOf($data));
    }
}