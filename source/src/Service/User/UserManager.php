<?php

namespace AC\Service\User;

use AC\Models\User\DTO\UserDTO;
use AC\Service\Http\Request;

class UserManager
{
    /**
     * @var UserDTO|null
     */
    protected ?UserDTO $user = null;

    /**
     * @Inject
     * @var Request
     */
    private Request $request;

    /**
     * UserManager constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->user = (!$this->user) ? $request->getUser() : $this->user;
    }
}