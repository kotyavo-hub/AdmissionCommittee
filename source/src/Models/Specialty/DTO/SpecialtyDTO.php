<?php

namespace AC\Models\Specialty\DTO;

use AC\Service\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Класс DTO для работы с данными о специальности
 *
 * Class SpecialtyDTO
 * @package AC\Models\Specialty\DTO
 */
class SpecialtyDTO extends DataTransferObject
{
    public int $code;

    public string $name;

    /**
     * Функция для получения данных из Request
     *
     * @see Request
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): self
    {
        return new self([
            'code' => (int)$request->getParamFromPostVar('speciality')['code'],
            'name' => $request->getParamFromPostVar('speciality')['name']
        ]);
    }
}