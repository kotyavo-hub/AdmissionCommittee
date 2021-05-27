<?php

namespace AC\Models\Leaver\IndividAchiev\DTO;

use AC\Models\Leaver\DTO\LeaverDTO;
use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * Класс коллекция DTO для хранения данных об индвидуальных достижениях абитуриента
 *
 * Class IndividAchievDTOCollection
 * @see LeaverDTO
 * @see IndividAchievDTO
 * @package AC\Models\Leaver\IndividAchiev\DTO
 */
class IndividAchievDTOCollection extends DataTransferObjectCollection
{
    public function current(): IndividAchievDTO
    {
        return parent::current();
    }

    public static function create(array $data): IndividAchievDTOCollection
    {
        return new static(IndividAchievDTO::arrayOf($data));
    }
}