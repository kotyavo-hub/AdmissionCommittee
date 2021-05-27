<?php

namespace AC\Models\Leaver\PreemRight\DTO;

use AC\Models\File\DTO\FileDTO;
use AC\Models\Leaver\DTO\LeaverDTO;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Класс DTO для хранение данных о приемущественных правах абитуриента
 *
 * Class PreemRightDTO
 * @see LeaverDTO
 * @package AC\Models\Leaver\PreemRight\DTO
 */
class PreemRightDTO extends DataTransferObject
{
    public ?int $id;

    public ?int $leaverId;

    public int $docType;

    public int $docSeria;

    public int $docNumber;

    public string $docDate;

    public string $docOrganization;

    public ?int $documentId;

    public ?FileDTO $document;
}