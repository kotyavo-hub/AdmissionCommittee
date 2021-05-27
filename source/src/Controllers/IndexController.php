<?php

namespace AC\Controllers;

use AC\Config\RoutesConfig;
use AC\Service\Http\Request;
use AC\Service\Http\Response;

/**
 * Класс Index страницы
 *
 * Class IndexController
 * @package AC\Controllers
 */
class IndexController extends BaseController
{
    /**
     * Константа
     *
     * Содержит название twig шаблона
     */
    protected const pageTemplate = 'indexTemplate.twig';

    /**
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        parent::__construct($response, $request);
    }

    /**
     * Action-функция
     *
     * Генерирует index страницу
     */
    public function render()
    {
        $this->getResponse()->display($this::pageTemplate, []);
    }
}