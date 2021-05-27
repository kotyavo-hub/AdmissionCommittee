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
use AC\Service\Mail\Mailer;
use AC\Service\User\UserManager;
use AC\Service\User\UserService;
use PHPMailer\PHPMailer\Exception;
use Rakit\Validation\RuleQuashException;

/**
 * Контроллер регистрации
 *
 * Class RegistrationController
 * @package AC\Controllers
 */
class RegistrationController extends BaseController
{
    /**
     * @Inject
     * @var Mailer
     */
    private Mailer $mailer;

    /**
     * @Inject
     * @var UserService
     */
    private UserService $userService;

    /**
     * @Inject
     * @var UserManager;
     */
    private UserManager $userManager;

    /**
     * @Inject
     * @var UserDAO
     */
    private UserDAO $userDao;

    protected const registrationTemplate = 'registrationTemplate.twig';
    protected const confirmEmailTemplate = 'confirmEmailTemplate.twig';

    /**
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        parent::__construct($response, $request);
    }

    /**
     * Action-функция
     * Генерирует index страницу
     */
    public function registrationGet()
    {
        $this->redirectAuthUser();

        $this->getResponse()->display($this::registrationTemplate, []);
    }

    /**
     * Action-функция
     * Обрабатывает отправленные данные пользователя и генерирует страницу ответа
     *
     * @throws ConfigFileNotFoundException
     * @throws Exception
     * @throws InvalidConfigException
     * @throws RuleQuashException
     */
    public function registrationPost()
    {
        $this->redirectAuthUser();

        $postDto = UserPostDTO::fromRequest($this->getRequest());

        $validation = $this->userService->validateRegistrationUserPost($postDto);

        $resultDto = null;

        if ($validation->fails()){
            $resultDto = new ResultDTO(
                StatusEnum::FAILURE(),
                $validation->getValidatedData(),
                $validation->errors()->firstOfAll(),
            );
        }

        if ($resultDto || $resultDto->status === StatusEnum::FAILURE) {
            $this->getResponse()->display($this::registrationTemplate, $resultDto->toArray());
            return;
        }

        $userDto = UserDTO::fromUserPostDto($postDto);

        $addResult = $this->userDao->add($userDto);

        if ($addResult) {
            $this->mailer->sendMail(
                $userDto->email,
                'Подтверждение регистрации',
                "Перейдите по ссылки для завершения регистрации - <a href='http://localhost/confirm_email/$userDto->emailHash/'>ссылка</a>"
            );
        }

        $resultDto = new ResultDTO(StatusEnum::SUCCESS());

        $this->getResponse()->display($this::confirmEmailTemplate, $resultDto->toArray());
    }

    /**
     * Action-функция
     * Обновляет статус email и генерирует страницу ответа
     *
     * @param string|null $emailHash
     */
    public function confirmEmailGet(string $emailHash = null)
    {
        $this->redirectAuthUser();

        if (!$emailHash) {
            return;
        }

        $updateResult = $this->userDao->updateConfirmEmail($emailHash);

        $resultDto = new ResultDTO(
            ($updateResult === 1) ? StatusEnum::SUCCESS() : StatusEnum::FAILURE(),
            ($updateResult === 1) ? ['confirmEmail' => $emailHash] : []
        );

        $this->getResponse()->display($this::confirmEmailTemplate, $resultDto->toArray());
    }

    protected function redirectAuthUser()
    {
        $user = $this->userManager->getUserFromRequest(
            $this->getRequest()
        );

        if ($user && $this->userManager->checkAuth($user)){
            $this->getResponse()->redirect('/');
        }
    }
}