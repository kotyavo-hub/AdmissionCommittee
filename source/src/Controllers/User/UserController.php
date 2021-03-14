<?php

namespace AC\Controllers\User;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;
use AC\Config\Validation\ValidationConfig;
use AC\Config\Validation\ValidationConfigKeys;
use AC\Controllers\BaseController;
use AC\Controllers\Enum\ResponseEnum;
use AC\Controllers\Enum\StatusEnum;
use AC\Models\User\UserDao;
use AC\Service\Mail\Mailer;
use PHPMailer\PHPMailer\Exception;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class UserController extends BaseController
{
    /**
     * @Inject
     * @var UserDao
     */
    private $userDao;

    /**
     * @Inject
     * @var Validator $validator
     */
    private $validator;

    /**
     * @Inject
     * @var ValidationConfig
     */
    private $validationConfig;

    /**
     * @Inject
     * @var Mailer
     */
    private $mailer;

    /**
     * @param $login
     * @param $email
     * @param $password
     * @param $confirmPassword
     * @param int $role
     * @return array|string[]
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function addUser($login, $email, $password, $confirmPassword, $role = 0)
    {
        $validation = $this->getValidation($login, $email, $password, $confirmPassword, $role);
        $validation->validate();

        $response = [
            ResponseEnum::STATUS => '',
            ResponseEnum::ERRORS => []
        ];

        if ($validation->fails()){
            $response[ResponseEnum::DATA] = $validation->getValidatedData();
            $response[ResponseEnum::STATUS] = StatusEnum::FAILURE;
            $response[ResponseEnum::ERRORS] = $validation->errors()->firstOfAll();

            return $response;
        }

        $emailHash = md5($login.time());
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $result = $this->userDao->add(
            $login,
            $email,
            $emailHash,
            $passwordHash,
            $role
        );

        if ($result) {
            $this->mailer->sendMail(
                $email,
                'Подтверждение регистрации',
                "Перейдите по ссылки для завершения регистрации - <a href='http://localhost/confirm_email/$emailHash/'>ссылка</a>"
            );
            $response[ResponseEnum::STATUS] = StatusEnum::SUCCESS;
            return $response;
        }

        return $response;
    }

    /**
     * @param $login
     * @param $email
     * @param $password
     * @param $confirmPassword
     * @param $role
     * @return Validation
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     */
    public function getValidation($login, $email, $password, $confirmPassword, $role): Validation
    {
        $rules = $this->validationConfig->getValidationRules(
            ValidationConfigKeys::REGISTRATION()
        );
        $messages = $this->validationConfig->getValidationMessages(
            ValidationConfigKeys::REGISTRATION()
        );

        $fields = [
            'login' => $login,
            'email' => $email,
            'password' => $password,
            'confirmPassword' => $confirmPassword,
            'role' => $role
        ];

        $validation = $this->validator->make($fields,$rules);

        $validation->setMessages($messages);

        return $validation;
    }
}