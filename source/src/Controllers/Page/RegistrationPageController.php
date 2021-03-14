<?php

namespace AC\Controllers\Page;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;
use AC\Controllers\Enum\ResponseEnum;
use AC\Controllers\Enum\StatusEnum;
use AC\Controllers\User\UserController;
use PHPMailer\PHPMailer\Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class RegistrationPageController extends BasePageController
{
    /**
     * @Inject
     * @var UserController
     */
    private $userController;

    protected const registrationTemplate = 'registrationTemplate.twig';
    protected const confirmEmailTemplate = 'confirmEmailTemplate.twig';

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render()
    {
        $this->display($this::registrationTemplate, []);
    }

    /**
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function registrationRender()
    {
        $response = $this->userController->addUser(
            $this->getRequest()->getParamFromPostVar('login'),
            $this->getRequest()->getParamFromPostVar('email'),
            $this->getRequest()->getParamFromPostVar('password'),
            $this->getRequest()->getParamFromPostVar('confirmPassword')
        );

        if ($response[ResponseEnum::STATUS] === StatusEnum::FAILURE) {
            $this->display($this::registrationTemplate, $response);
        } else if ($response[ResponseEnum::STATUS] === StatusEnum::SUCCESS) {
            $this->display($this::confirmEmailTemplate, []);
        }
    }

    public function confirmEmailRender($emailHash = null){
        $response[ResponseEnum::DATA][$emailHash] = $emailHash;
    }
}