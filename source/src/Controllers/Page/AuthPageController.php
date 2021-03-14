<?php


namespace AC\Controllers\Page;


use AC\Service\Http\Request;
use AC\Service\Http\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AuthPageController extends BasePageController
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
     * @var Environment
     */
    private $twig;

    protected const pageTemplate = 'authTemplate.twig';

    /**
     * @param Response $response
     * @param Request $request
     * @param Environment $twig
     */
    function __construct(Response $response, Request $request, Environment $twig)
    {
        $this->response = $response;
        $this->request  = $request;
        $this->twig     = $twig;

        parent::__construct($response, $request, $twig);
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render()
    {
        //$this->getRequest()->getRequestParam('');

        $this->display($this::pageTemplate, []);
    }
}