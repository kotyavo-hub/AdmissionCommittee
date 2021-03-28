<?php

namespace AC\Controllers;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;
use AC\Controllers\Enum\StatusEnum;
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

    protected const indexTemplate = 'Applying/indexTemplate.twig';

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
    public function indexPost(?string $guid = null)
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
                "Перейдите по ссылки для продолжения подачи заявления - <a href='http://localhost/applying/$leaverDto->guid'>ссылка</a>"
            );
        }

        $resultDto = new ResultDTO(StatusEnum::SUCCESS());

        $this->getResponse()->display($this::indexTemplate, $resultDto->toArray());
    }
}