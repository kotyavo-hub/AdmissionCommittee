<?php declare(strict_types=1);

namespace AC\Controllers;

use AC\Controllers\Interfaces\iController;
use AC\Service\Http\Request;
use AC\Service\Http\Response;
use AC\Service\Http\ResponseInterface;

abstract class BaseController implements iController
{
    /**
     * @Inject
     * @var Response
     */
    private $response;

    /**
     * @Inject
     * @var Request
     */
    private $request;

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
     * @return ResponseInterface
     */
    protected function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        return $this->request;
    }
}