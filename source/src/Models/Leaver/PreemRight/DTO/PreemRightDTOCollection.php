<?php

namespace AC\Models\Leaver\PreemRight\DTO;

use AC\Models\Leaver\DTO\LeaverDTO;
use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * Класс коллекция DTO для работы с данными преемущественных правах
 *
 * Class PreemRightDTOCollection
 * @see LeaverDTO
 * @see PreemRightDTO
 * @package AC\Models\Leaver\PreemRight\DTO
 */
class PreemRightDTOCollection extends DataTransferObjectCollection
{
    public function current(): PreemRightDTO
    {
        return parent::current();
    }

    public static function create(array $data): PreemRightDTOCollection
    {
        return new static(PreemRightDTO::arrayOf($data));
    }
}