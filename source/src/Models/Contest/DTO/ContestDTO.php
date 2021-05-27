<?php

namespace AC\Models\Contest\DTO;

use AC\Models\Faculty\DTO\FacultyDTO;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Класс DTO для работы с данными конкурса
 *
 * Class ContestDTO
 * @package AC\Models\Contest\DTO
 */
class ContestDTO extends DataTransferObject
{
    public int $id;

    public string $codeOKCO;

    public int $urov;

    public int $facultyCode;

    public int $specialityCode;

    public string $specializationBrief;

    public string $speciality;

    public string $specialization;

    public int $planInternalCommerce;

    public int $planExternalCommerce;

    public int $planIECommerce;

    public int $planInternalQuotas;

    public int $planExternalQuotas;

    public int $planIEQuotas;

    public int $planInternalTarget;

    public int $planExternalTarget;

    public int $planIETarget;

    public int $planInternal;

    public int $planExternal;

    public int $planIE;

    public ?float $periodInternalYears;

    public ?int $periodInternalMonths;

    public ?float $periodExternalYears;

    public ?int $periodExternalMonths;

    public ?float $periodIEYears;

    public ?int $periodIEMonths;

    public ?float $priceInternal;

    public ?float $priceInternalForeign;

    public ?float $priceExternal;

    public ?float $PriceExternalForeign;

    public ?float $priceIE;

    public ?int $priceIEForeign;

    public int $noReceptionInternal;

    public int $noReceptionExternal;

    public int $noReceptionIE;

    public int $exam1;

    public int $exam2;

    public int $exam3;
}