<?php

namespace AC\Controllers;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;
use AC\Controllers\Enum\StatusEnum;
use AC\Controllers\Exceptions\NotFoundGuidException;
use AC\Controllers\Exceptions\NotFoundLeaverException;
use AC\Models\Dictionary\DAO\DictionaryDAO;
use AC\Models\Dictionary\Enum\DictionaryTableEnum;
use AC\Models\File\DAO\FileDAO;
use AC\Models\Leaver\DAO\LeaverDAO;
use AC\Models\Leaver\DTO\LeaverDTO;
use AC\Models\Result\ResultDTO;
use AC\Models\User\DAO\UserDAO;
use AC\Models\User\DTO\UserDTO;
use AC\Models\User\Enum\UserRoleEnum;
use AC\Service\Http\Request;
use AC\Service\Http\Response;
use AC\Service\Leaver\ApplyingService;
use AC\Service\Mail\Mailer;
use AC\Service\User\UserManager;
use Exception;
use Rakit\Validation\RuleQuashException;

/**
 * Контроллер подачи и редактирования заявления
 * Class ApplyingController
 * @package AC\Controllers
 */
class ApplyingController extends BaseController
{
    /**
     * @Inject
     * @var ApplyingService
     */
    private ApplyingService $applyingService;

    /**
     * @Inject
     * @var Mailer
     */
    private Mailer $mailer;

    /**
     * @Inject
     * @var LeaverDAO
     */
    private LeaverDAO $leaverDao;

    /**
     * @Inject
     * @var DictionaryDAO
     */
    private DictionaryDAO $dictionaryDao;

    /**
     * @Inject
     * @var FileDAO
     */
    private FileDAO $fileDao;

    /**
     * @Inject
     * @var UserManager
     */
    private UserManager $userManager;

    /**
     * @Inject
     * @var UserDAO
     */
    private UserDAO $userDao;

    protected const indexTemplate = 'Applying/indexTemplate.twig';
    protected const applyingTemplate = 'Applying/applyingTemplate.twig';
    protected const applyingFinalTemplate = 'Applying/applyingFinalTemplate.twig';

    /**
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        parent::__construct($response, $request);
    }

    /**
     * Метод рендера index страницы
     */
    public function indexGet()
    {
        $this->getResponse()->display($this::indexTemplate, []);
    }

    /**
     * @see LeaverDTO::fromRequest()
     *
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws RuleQuashException
     * @throws Exception
     */
    public function indexPost()
    {
        $leaverDto = LeaverDTO::fromRequest($this->getRequest());

        $validation = $this->applyingService->validateConfigEmailLeaverPost($leaverDto);

        $resultDto = null;

        if ($validation->fails()){
            $resultDto = new ResultDTO(
                StatusEnum::FAILURE(),
                $validation->getValidatedData(),
                $validation->errors()->firstOfAll(),
            );
        }

        if ($resultDto || $resultDto->status === StatusEnum::FAILURE) {
            $this->getResponse()->display($this::indexTemplate, $resultDto->toArray());
            return;
        }

        $leaverDto->guid = md5($leaverDto->email.time());

        $leaverId = $this->leaverDao->addNewLeaver($leaverDto);

        if ($leaverId && $leaverDto->guid) {
            $this->mailer->sendMail(
                $leaverDto->email,
                'Продолжение подачи заявления',
                "Перейдите по ссылки для продолжения подачи заявления - <a href='http://localhost/applying/$leaverDto->guid/'>ссылка</a>"
            );
        }

        $resultDto = new ResultDTO(StatusEnum::SUCCESS());

        $this->getResponse()->display($this::indexTemplate, $resultDto->toArray());
    }

    /**
     * @param string|null $guid
     * @throws NotFoundGuidException
     * @throws NotFoundLeaverException
     */
    public function applyingGet(?string $guid = null)
    {
        $this->redirectAuthUser();

        if (!$guid) {
            throw new NotFoundGuidException();
        }

        $leaver = ($row = $this->leaverDao->getByGuid($guid)) ? new LeaverDTO($row) : null;

        if ($leaver->statusComplete) {
            $this->getResponse()->redirect('/');
        }

        if(!$leaver) {
            throw new NotFoundLeaverException();
        }

        //$this->applyingService->setLeaverRights($leaver);
        //$this->applyingService->setLeaverFiles($leaver);

        if (!$leaver) {
            throw new NotFoundGuidException();
        }

        if ($leaver->email && !$leaver->statusEmail) {
            $leaver->statusEmail = ($this->leaverDao->updateStatusEmail($leaver->id)) ? 1 : $leaver->statusEmail;
        }

        $data = [
            'leaver'              => $leaver->toArray(),
            'genders'             => $this->dictionaryDao->getAll(DictionaryTableEnum::GENDERS()),
            'citizens'            => $this->dictionaryDao->getAll(DictionaryTableEnum::CITIZEN()),
            'countries'           => $this->dictionaryDao->getAll(DictionaryTableEnum::COUNTRIES()),
            'identityDocTypes'    => $this->dictionaryDao->getAll(DictionaryTableEnum::IDENTITY_DOC_TYPES()),
            'languages'           => $this->dictionaryDao->getAll(DictionaryTableEnum::LANGUAGES()),
            'prestarts'           => $this->dictionaryDao->getAll(DictionaryTableEnum::PRESTARTS()),
            'exams'               => $this->dictionaryDao->getAll(DictionaryTableEnum::EXAMS()),
            'preemRightsTypes'    => $this->dictionaryDao->getAll(DictionaryTableEnum::PREEM_RIGHTS_TYPES()),
            'individAchievsTypes' => $this->dictionaryDao->getAll(DictionaryTableEnum::INDIVID_ACHIEVS_TYPES()),
            'specRightsTypes'     => $this->dictionaryDao->getAll(DictionaryTableEnum::SPEC_RIGHTS_TYPES())
        ];

        $resultDto = new ResultDTO(
            StatusEnum::SUCCESS(),
            $data,
        );

        $this->getResponse()->display($this::applyingTemplate, $resultDto->toArray());
    }

    /**
     * @param string|null $guid
     * @throws NotFoundGuidException
     * @throws Exception
     */
    public function applyingPost(?string $guid = null)
    {
        $this->redirectAuthUser();

        if (!$guid) {
            throw new NotFoundGuidException();
        }

        $leaverDto = new LeaverDTO($this->leaverDao->getByGuid($guid));

        if ($leaverDto->statusComplete) {
            $this->getResponse()->redirect('/');
        }

        $leaverPostDto = LeaverDTO::fromRequest($this->getRequest());

        $leaverPostDto->statusComplete = 1;

        if (!$leaverPostDto || !$leaverDto) {
            throw new NotFoundLeaverException();
        }

        $leaverPostDto->statusComplete = 1;

        $this->applyingService->setChildrenDtoLeaverId($leaverPostDto);

        $this->applyingService->addLeaverFiles($leaverPostDto);
        $this->applyingService->addChildrenDto($leaverPostDto);

        $this->leaverDao->updateByApplying($leaverPostDto);

        $userPassword = $this->userManager->randomPassword();

        $userDto = new UserDTO([
            'role' => UserRoleEnum::LEAVER,
            'email' => $leaverDto->email,
            'login' => 'leaver' . $leaverDto->id,
            'hashPassword' => password_hash($userPassword, PASSWORD_DEFAULT),
            'confirmEmail' => 1,
            'entityId' => $leaverDto->id
        ]);

        $addUserResult = $this->userDao->add($userDto);

        if ($addUserResult) {
            $this->mailer->sendMail(
                $userDto->email,
                'Успешная регистрация',
                "Вы успешно подали заявления. Данные для входа: <br> Логин: $userDto->login <br> Пароль: $userPassword"
            );
        }

        $resultDto = new ResultDTO(StatusEnum::SUCCESS());

        $this->getResponse()->display($this::applyingFinalTemplate, $resultDto->toArray());
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