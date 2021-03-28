<?php

namespace AC\Config\Validation\Rules\Leaver;

use AC\Models\Leaver\DAO\LeaverDAO;
use Rakit\Validation\Rule;

class UniqueEmailRule extends Rule
{
    protected $message = "Email :value has been used";

    protected LeaverDAO $leaverDao;

    public function __construct(LeaverDAO $leaverDao)
    {
        $this->leaverDao = $leaverDao;
    }

    public function check($value): bool
    {
        return !$this->leaverDao->existEmail($value);
    }
}