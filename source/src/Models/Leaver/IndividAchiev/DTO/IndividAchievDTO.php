<?php

namespace AC\Models\Leaver\IndividAchiev\DTO;

use AC\Models\File\DTO\FileDTO;
use AC\Models\Leaver\DTO\LeaverDTO;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Класс DTO для хранения данных об индвидуальных достижениях абитуриента
 *
 * Class IndividAchiev
 * @see LeaverDTO
 * @package AC\Models\Leaver\IndividAchiev\DTO
 */
class IndividAchievDTO extends DataTransferObject
{
    public ?int $id;

    public ?int $leaverId;

    public int $docType;

    public int $docSeria;

    public int $docNumber;

    public string $docDate;

    public string $docOrganization;

    public string $documentId;

    public ?FileDTO $document;
}