<?php

namespace AC\Models\Result;

use AC\Controllers\Enum\ResultEnum;
use AC\Controllers\Enum\StatusEnum;
use AC\Service\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ResultDTO extends DataTransferObject
{
    public int $status;

    public array $errors;

    public array $data;

    /**
     * @param StatusEnum $status
     * @param array $errors
     * @param array $data
     */
    public function __construct(StatusEnum $status, array $data = [], array $errors = [])
    {
        parent::__construct([
            ResultEnum::STATUS => $status->getValue(),
            ResultEnum::DATA => $data,
            ResultEnum::ERRORS => $errors
        ]);
    }
}