<?php

namespace AC\Models\File\DTO;

use AC\Models\Leaver\DTO\LeaverDTO;
use AC\Service\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Класс DTO для хранения данных о файлах
 *
 * Class FileDTO
 * @package AC\Models\File\DTO
 */
class FileDTO extends DataTransferObject
{
    public ?int $id;

    public ?string $name;

    public ?string $type;

    public ?string $content;

    public ?int $size;

    public ?int $leaverId;

    public static function fromRequestFile(array $file): self
    {
        return new self([
            'name' => ($file['name']) ?: null,
            'type' => ($file['type']) ?: null,
            'content' => ($tmpName = $file['tmp_name']) ? file_get_contents($tmpName) : null,
            'size' => ($file['size']) ?: null
        ]);
    }
}