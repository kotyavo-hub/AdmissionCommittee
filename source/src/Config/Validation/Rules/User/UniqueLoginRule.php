<?php

namespace AC\Config\Validation\Rules\User;

use AC\Models\User\DAO\UserDAO;
use Rakit\Validation\Rule;

class UniqueLoginRule extends Rule
{
    protected $message = "Login :value has been used";

    protected UserDAO $userDao;

    public function __construct(UserDAO $userDao)
    {
        $this->userDao = $userDao;
    }

    public function check($value): bool
    {
        return !$this->userDao->existLogin($value);
    }
}