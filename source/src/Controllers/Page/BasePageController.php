<?php

namespace AC\Controllers\Page;

use AC\Controllers\BaseController;
use AC\Controllers\Interfaces\iPageController;
use AC\Service\Http\Request;
use AC\Service\Http\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class BasePageController extends BaseController implements iPageController
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
     * @Inject
     * @var Environment
     */
    private $twig;

    /**
     * @param Response $response
     * @param Request $request
     * @param Environment $twig
     */
    public function __construct(Response $response, Request $request, Environment $twig)
    {
        $this->response = $response;
        $this->request  = $request;
        $this->twig     = $twig;
        parent::__construct($response, $request);
    }

    private function getMenuData()
    {
        return [
            [
                'href' => '/registration/',
                'name' => 'Регистрация',
            ],
            [
                'href' => '/auth/',
                'name' => 'Вход',
            ],
        ];
    }

    /**
     * @param string $template
     * @param $data
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function display(string $template, $data)
    {
        $data['menu'] = $this->getMenuData();
        $this->twig->display($template, $data);
    }
}