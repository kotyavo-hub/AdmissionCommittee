<?php

namespace AC\Controllers;

use AC\Controllers\Enum\StatusEnum;
use AC\Controllers\Exceptions\NotFoundDocumentException;
use AC\Controllers\Exceptions\NotFoundIdException;
use AC\Models\Dictionary\DAO\DictionaryDAO;
use AC\Models\Dictionary\Enum\DictionaryTableEnum;
use AC\Models\File\DAO\FileDAO;
use AC\Models\File\DTO\FileDTO;
use AC\Models\Leaver\DTO\LeaverDTO;
use AC\Models\Result\ResultDTO;
use AC\Models\User\Enum\UserRoleEnum;
use AC\Service\Http\Enum\HttpCodeEnum;
use AC\Service\Http\Request;
use AC\Service\Http\Response;
use AC\Service\Leaver\ApplyingService;
use AC\Service\User\UserManager;

/**
 * Контроллер для получение личных дел
 *
 * Class PersonalController
 * @package AC\Controllers
 */
class PersonalController extends BaseController
{
    /**
     * @Inject
     * @var UserManager
     */
    private UserManager $userManager;

    /**
     * @Inject
     * @var ApplyingService
     */
    private ApplyingService $applyingService;

    /**
     * @Inject
     * @var DictionaryDAO
     */
    private DictionaryDAO $dictionaryDao;

    protected const personalTemplate = 'Personal/personalTemplate.twig';
    protected const personalAllTemplate = 'Personal/personalAllTemplate.twig';

    /**
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        parent::__construct($response, $request);
    }

    /**
     * @param string|null $id
     * @throws NotFoundIdException
     */
    public function personalGet(string $id = null)
    {
        $response = $this->getResponse();

        if (!(int)$id) {
            $response->setCode(HttpCodeEnum::NOT_FOUND());
            throw new NotFoundIdException();
        }

        $user = $this->userManager->getUserFromRequest($this->getRequest());

        if (
            !($this->userManager->checkUserPermission($user, UserRoleEnum::LEAVER()) ||
            $this->userManager->checkUserPermission($user, UserRoleEnum::INSPECTOR()))
        ) {
            $response->setCode(HttpCodeEnum::FORBIDDEN());
            return;
        }

        $leaver = $this->applyingService->getLeaverAllById($user->entityId);

        if (!($user->role === UserRoleEnum::LEAVER || !($user->entityId == $leaver->id))) {
            $response->setCode(HttpCodeEnum::FORBIDDEN());
            return;
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

        $result = new ResultDTO(
            StatusEnum::SUCCESS(),
            $data
        );

        $response->display($this::personalTemplate, $result->toArray());
    }

    /**
     * @throws NotFoundIdException
     */
    public function personalIndexGet()
    {
        $response = $this->getResponse();

        $user = $this->userManager->getUserFromRequest($this->getRequest());

        if ($user->role === UserRoleEnum::LEAVER && $user->entityId) {
            $this->personalGet((int)$user->entityId);
        } else {
            $response->setCode(HttpCodeEnum::NOT_FOUND());
            throw new NotFoundIdException();
        }
    }

    public function personalAllGet()
    {
        $response = $this->getResponse();

        $user = $this->userManager->getUserFromRequest($this->getRequest());

        if (!$this->userManager->checkUserPermission($user, UserRoleEnum::INSPECTOR())) {
            $response->setCode(HttpCodeEnum::FORBIDDEN());
            return;
        }

        $leavers = $this->applyingService->getAllLeavers();

        foreach ($leavers as $leaver) {
            $this->applyingService->getChildrenAndFilesByLeaver($leaver);
        }

        $leaver = $this->applyingService->getLeaverAllById($user->entityId);

        $data = [
            'leavers'              => $leaver->toArray(),
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

        $result = new ResultDTO(
            StatusEnum::SUCCESS(),
            $data
        );

        $response->display($this::personalAllTemplate, $result->toArray());
    }
}