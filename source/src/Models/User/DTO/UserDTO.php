<?php

namespace AC\Models\User\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class UserDTO extends DataTransferObject
{
    /** @var int|null */
    public ?int $id;

    /** @var string */
    public string $login;

    /** @var string|null */
    public ?string $hashPassword;

    /** @var string */
    public string $email;

    /** @var string|null */
    public ?string $emailHash;

    /** @var int */
    public int $role;

    /** @var null|int */
    public ?int $confirmEmail;

    public static function fromUserPostDto(UserPostDTO $userPostDTO): self
    {
        return new self([
            'login' => $userPostDTO->login,
            'hashPassword' => password_hash($userPostDTO->password, PASSWORD_DEFAULT),
            'email' => $userPostDTO->email,
            'emailHash' => md5($userPostDTO->login.time()),
            'role' => $userPostDTO->role,
        ]);
    }
}