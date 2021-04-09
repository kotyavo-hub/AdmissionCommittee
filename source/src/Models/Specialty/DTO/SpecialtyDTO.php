<?php

namespace AC\Models\Specialty\DTO;

use AC\Service\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class SpecialtyDTO extends DataTransferObject
{
    public int $code;

    public string $name;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'code' => (int)$request->getParamFromPostVar('speciality')['code'],
            'name' => $request->getParamFromPostVar('speciality')['name']
        ]);
    }
}