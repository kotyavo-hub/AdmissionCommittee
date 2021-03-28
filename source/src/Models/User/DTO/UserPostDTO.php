<?php

namespace AC\Models\User\DTO;

use AC\Service\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class UserPostDTO extends DataTransferObject
{
    public string $login;

    public ?string $email;

    public string $password;

    public ?string $confirmPassword;

    public ?int $role;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'login' => strtolower(trim($request->getParamFromPostVar('login'))),
            'email' => trim($request->getParamFromPostVar('email')),
            'password' => trim($request->getParamFromPostVar('password')),
            'confirmPassword' => trim($request->getParamFromPostVar('confirmPassword')),
            'role' => ($request->getParamFromPostVar('role')) ? $request->getParamFromPostVar('role') : 0,
        ]);
    }
}