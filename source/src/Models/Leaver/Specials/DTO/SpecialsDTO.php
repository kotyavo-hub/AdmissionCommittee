<?php

namespace AC\Models\Leaver\Specials\DTO;

use AC\Models\Contest\DTO\ContestDTO;
use AC\Models\File\DTO\FileDTO;
use AC\Models\Leaver\DTO\LeaverDTO;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Класс DTO для хранение данных о конкурсах абитуриента
 *
 * Class SpecialsDTO
 * @see LeaverDTO
 * @package AC\Models\Leaver\Specials\DTO
 */
class SpecialsDTO extends DataTransferObject
{
    public ?int $id;

    public int $idContest;

    public ?array $contest;

    public ?int $leaverId;

    public int $planInternalCommerce = 0;

    public int $planExternalCommerce = 0;

    public int $planIECommerce = 0;

    public int $planInternalQuotas = 0;

    public int $planExternalQuotas = 0;

    public int $planIEQuotas = 0;

    public int $planInternalTarget = 0;

    public int $planExternalTarget = 0;

    public int $planIETarget = 0;

    public int $planInternal = 0;

    public int $planExternal = 0;

    public int $planIE = 0;

    public ?int $targetDocId;

    public ?FileDTO $targetDocFile;
}