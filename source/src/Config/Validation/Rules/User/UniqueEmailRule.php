<?php

namespace AC\Config\Validation\Rules\User;

use AC\Models\User\DAO\UserDAO;
use Rakit\Validation\Rule;

class UniqueEmailRule extends Rule
{
    protected $message = "Email :value has been used";

    protected UserDAO $userDao;

    public function __construct(UserDAO $userDao)
    {
        $this->userDao = $userDao;
    }

    public function check($value): bool
    {
        return !$this->userDao->existEmail($value);
    }
}