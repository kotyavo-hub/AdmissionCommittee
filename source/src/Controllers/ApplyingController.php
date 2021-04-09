<?php

namespace AC\Controllers;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;
use AC\Controllers\Enum\StatusEnum;
use AC\Controllers\Exceptions\NotFoundGuidException;
use AC\Models\Dictionary\DAO\DictionaryDAO;
use AC\Models\Dictionary\Enum\DictionaryTableEnum;
use AC\Models\Leaver\DAO\LeaverDAO;
use AC\Models\Leaver\DTO\LeaverDTO;
use AC\Models\Result\ResultDTO;
use AC\Service\Http\Request;
use AC\Service\Http\Response;
use AC\Service\Leaver\ApplyingService;
use AC\Service\Mail\Mailer;
use Exception;

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

    protected const indexTemplate = 'Applying/indexTemplate.twig';
    protected const applyingTemplate = 'Applying/applyingTemplate.twig';

    /**
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        parent::__construct($response, $request);
    }

    public function indexGet()
    {
        $this->getResponse()->display($this::indexTemplate, []);
    }

    /**
     * @param string|null $guid
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
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
     */
    public function applyingGet(?string $guid = null)
    {
        if (!$guid) {
            throw new NotFoundGuidException();
        }

        $leaver = ($row = $this->leaverDao->getByGuid($guid)) ? new LeaverDTO($row) : null;

        if (!$leaver) {
            throw new NotFoundGuidException();
        }

        if ($leaver->email && !$leaver->statusEmail) {
            $leaver->statusEmail = ($this->leaverDao->updateStatusEmail($leaver->id)) ? 1 : $leaver->statusEmail;
        }

        $data = [
            'leaver'           => $leaver->toArray(),
            'genders'          => $this->dictionaryDao->getAll(DictionaryTableEnum::GENDERS()),
            'citizens'         => $this->dictionaryDao->getAll(DictionaryTableEnum::CITIZEN()),
            'countries'        => $this->dictionaryDao->getAll(DictionaryTableEnum::COUNTRIES()),
            'identityDocTypes' => $this->dictionaryDao->getAll(DictionaryTableEnum::IDENTITY_DOC_TYPES()),
            'languages'        => $this->dictionaryDao->getAll(DictionaryTableEnum::LANGUAGES()),
            'prestarts'        => $this->dictionaryDao->getAll(DictionaryTableEnum::PRESTARTS()),
            'exams'            => $this->dictionaryDao->getAll(DictionaryTableEnum::EXAMS())
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
     */
    public function applyingPost(?string $guid = null)
    {
        if (!$guid) {
            throw new NotFoundGuidException();
        }

        $leaver = LeaverDTO::fromRequest($this->getRequest());

        if (!$leaver) {
            throw new NotFoundGuidException();
        }

        echo '<pre>';
        var_dump($leaver->exams);
        echo '</pre>';
    }
}