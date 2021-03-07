<?php declare(strict_types=1);

namespace AC\Controllers;

use AC\Service\Http\Request;
use AC\Service\Http\Response;
use AC\Service\Http\ResponseInterface;

class BaseController
{
    /**
     * @var Response
     */
    private $response;

    /**
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
        $this->request = $request;
    }

    /**
     * @param string $var
     * @param int $type
     * @param string $validationMsg
     * @throws InvalidParameterException
     */
    protected function filterValidateType(string $var, int $type, string $validationMsg)
    {
        /** @noinspection ReturnFalseInspection */
        if (false === filter_var($var, $type)) {
            //throw Exception('test');//InvalidParameterException::create($validationMsg);
        }
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