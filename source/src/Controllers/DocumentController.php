<?php

namespace AC\Controllers;

use AC\Controllers\Exceptions\NotFoundDocumentException;
use AC\Controllers\Exceptions\NotFoundIdException;
use AC\Models\File\DAO\FileDAO;
use AC\Models\File\DTO\FileDTO;
use AC\Models\User\Enum\UserRoleEnum;
use AC\Service\Http\Enum\HttpCodeEnum;
use AC\Service\Http\Request;
use AC\Service\Http\Response;
use AC\Service\User\UserManager;

/**
 * Контроллер для получение документов
 *
 * Class DocumentController
 * @package AC\Controllers
 */
class DocumentController extends BaseController
{
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
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        parent::__construct($response, $request);
    }

    /**
     * @param string|null $id
     * @throws NotFoundDocumentException
     * @throws NotFoundIdException
     */
    public function documentGet(string $id = null)
    {
        $response = $this->getResponse();

        $user = $this->userManager->getUserFromRequest($this->getRequest());

        if (!(int)$id) {
            $response->setCode(HttpCodeEnum::NOT_FOUND());
            throw new NotFoundIdException();
        }

        if (!$documentRes = $this->fileDao->getById($id)) {
            $response->setCode(HttpCodeEnum::NOT_FOUND());
            throw new NotFoundDocumentException();
        }

        $document = new FileDTO($documentRes);

//        if (
//            !($this->userManager->checkUserPermission($user, UserRoleEnum::INSPECTOR())) ||
//            !($this->userManager->checkUserPermission($user, UserRoleEnum::LEAVER()) && $user->entityId != $document->leaverId)
//        )
//        {
//            $response->setCode(HttpCodeEnum::FORBIDDEN());
//        }

        header("Content-length: $document->size");
        header("Content-type: $document->type");
        //$response->setHeader('Content-Disposition: attachment; filename="' . $document->name . '"');
        echo $document->content;
    }
}