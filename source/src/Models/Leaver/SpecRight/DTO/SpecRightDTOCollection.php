<?php

namespace AC\Models\Leaver\SpecRight\DTO;

use AC\Models\Leaver\DTO\LeaverDTO;
use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * Класс коллекция DTO для хранение данных о особых правах абитуриента
 *
 * Class SpecRightDTOCollection
 * @see LeaverDTO
 * @see SpecRightDTO
 * @package AC\Models\Leaver\SpecRight\DTO
 */
class SpecRightDTOCollection extends DataTransferObjectCollection
{
    public function current(): SpecRightDTO
    {
        return parent::current();
    }

    public static function create(array $data): SpecRightDTOCollection
    {
        return new static(SpecRightDTO::arrayOf($data));
    }
}