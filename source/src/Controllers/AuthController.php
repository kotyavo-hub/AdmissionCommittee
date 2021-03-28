<?php

namespace AC\Controllers;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;
use AC\Controllers\Enum\StatusEnum;
use AC\Models\Result\ResultDTO;
use AC\Models\User\DAO\UserDAO;
use AC\Models\User\DTO\UserDTO;
use AC\Models\User\DTO\UserPostDTO;
use AC\Service\Http\Request;
use AC\Service\Http\Response;
use AC\Service\User\UserService;

class AuthController extends BaseController
{
    /**
     * @Inject
     * @var UserDAO
     */
    private UserDAO $userDao;

    /**
     * @Inject
     * @var UserService
     */
    private UserService $userService;

    protected const authTemplate = 'authTemplate.twig';

    /**
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        parent::__construct($response, $request);
    }

    public function loginGet()
    {
       $this->redirectAuthUser();

       $this->getResponse()->display(self::authTemplate, []);
    }

    /**
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     */
    public function loginPost()
    {
        $this->redirectAuthUser();

        $user = $this->getRequest()->getUser();

        if ($user && $user->checkAuth()){
            $this->getResponse()->redirect('/');
        }

        $postDto    = UserPostDTO::fromRequest($this->getRequest());

        $validation = $this->userService->validateAuthUserPost($postDto);

        $errors     = [];

        if ($validation->fails()){
            $errors = $validation->errors()->firstOfAll();
        }

        $user = $this->userDao->getByLogin($postDto->login);

        if (!$user) {
            $errors['authError'] = 'Ошибка входа. Проверьте логин или пароль.';
        }

        $userDto = new UserDTO($user);

        if (!password_verify($postDto->password, $userDto->hashPassword)) {
            $errors['authError'] = 'Ошибка входа. Проверьте логин или пароль.';
        }

        if (count($errors)) {
            $resultDto = new ResultDTO(StatusEnum::FAILURE(), $postDto->toArray(), $errors);
            $this->getResponse()->display(static::authTemplate, $resultDto->toArray());
            return;
        }

        $this->getResponse()->setParamFromSessionVar('User', $userDto);

        $this->redirectAuthUser();
    }

    public function exitGet()
    {
        $this->getResponse()->destroySession();
        $this->getResponse()->redirect('/');
    }

    protected function redirectAuthUser()
    {
        $user = $this->getRequest()->getUser();

        if ($user && $user->checkAuth()){
            $this->getResponse()->redirect('/');
        }
    }
}