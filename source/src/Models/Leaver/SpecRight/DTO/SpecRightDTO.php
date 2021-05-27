<?php

namespace AC\Models\Leaver\SpecRight\DTO;

use AC\Models\File\DTO\FileDTO;
use AC\Models\Leaver\DTO\LeaverDTO;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Класс DTO для хранение данных о особых правах абитуриента
 *
 * Class SpecRightDTO
 * @see LeaverDTO
 * @package AC\Models\Leaver\SpecRight\DTO
 */
class SpecRightDTO extends DataTransferObject
{
    public ?int $id;

    public ?int $leaverId;

    public string $docType;

    public ?int $documentId;

    public ?FileDTO $document;
}