<?php declare(strict_types=1);

namespace AC\Controllers;

use AC\Controllers\Interfaces\iController;
use AC\Service\Http\Request;
use AC\Service\Http\Response;
use AC\Service\Http\ResponseInterface;

/**
 * Базовый класс для работы с контроллера
 *
 * Class BaseController
 * @package AC\Controllers
 */
abstract class BaseController implements iController
{
    /**
     * @var Response
     */
    private Response $response;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        $this->response = $response;
        $this->request  = $request;
    }

    /**
     * Функция возвращает Response класс
     * @return ResponseInterface
     */
    protected function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * Функция возвращает Request класс
     * @return Request
     */
    protected function getRequest(): Request
    {
        return $this->request;
    }
}