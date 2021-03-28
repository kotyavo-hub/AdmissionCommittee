<?php

namespace AC\Service\User;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;
use AC\Config\Validation\Rules\User\UniqueEmailRule;
use AC\Config\Validation\Rules\User\UniqueLoginRule;
use AC\Config\Validation\ValidationConfig;
use AC\Config\Validation\ValidationConfigKeys;
use AC\Models\User\DAO\UserDAO;
use AC\Models\User\DTO\UserPostDTO;
use Rakit\Validation\RuleQuashException;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;


class UserService
{
    /**
     * @Inject
     * @var ValidationConfig
     */
    private ValidationConfig $validationConfig;

    /**
     * @Inject
     * @var Validator
     */
    private Validator $validator;

    /**
     * @Inject
     * @var UserDAO
     */
    private UserDAO $userDao;

    /**
     * @param UserPostDTO $dto
     * @return Validation
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     */
    public function validateAuthUserPost(UserPostDTO $dto): Validation
    {
        $validation = $this->getUserAuthValidation($dto);
        $validation->validate();

        return $validation;
    }

    /**
     * @param UserPostDTO $dto
     * @return Validation
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     * @throws RuleQuashException
     */
    public function validateRegistrationUserPost(UserPostDTO $dto): Validation
    {
        $validation = $this->getUserRegistrationValidation($dto);
        $validation->validate();

        return $validation;
    }

    /**
     * @param UserPostDTO $dto
     * @return Validation
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     */
    protected function getUserAuthValidation(UserPostDTO $dto): Validation
    {
        $rules = $this->validationConfig->getValidationRules(
            ValidationConfigKeys::AUTHENTICATION()
        );
        $messages = $this->validationConfig->getValidationMessages(
            ValidationConfigKeys::AUTHENTICATION()
        );

        $fields = [
            'login' => $dto->login,
            'password' => $dto->password,
        ];

        $validation = $this->validator->make($fields,$rules);

        $validation->setMessages($messages);

        return $validation;
    }

    /**
     * @param UserPostDTO $dto
     * @return Validation
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     * @throws RuleQuashException
     */
    protected function getUserRegistrationValidation(UserPostDTO $dto): Validation
    {
        $rules = $this->validationConfig->getValidationRules(
            ValidationConfigKeys::REGISTRATION()
        );
        $messages = $this->validationConfig->getValidationMessages(
            ValidationConfigKeys::REGISTRATION()
        );

        $fields = [
            'login' => $dto->login,
            'email' => $dto->email,
            'password' => $dto->password,
            'confirmPassword' => $dto->confirmPassword,
            'role' => $dto->role
        ];

        $this->validator->addValidator('uniqueEmail', new UniqueEmailRule($this->userDao));
        $this->validator->addValidator('uniqueLogin', new UniqueLoginRule($this->userDao));

        $validation = $this->validator->make($fields,$rules);

        $validation->setMessages($messages);

        return $validation;
    }
}