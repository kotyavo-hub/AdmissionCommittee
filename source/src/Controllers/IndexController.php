<?php

namespace AC\Controllers;

use AC\Service\Http\Request;
use AC\Service\Http\Response;

class IndexController extends BaseController
{
    protected const pageTemplate = 'indexTemplate.twig';

    /**
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        parent::__construct($response, $request);
    }

    public function render()
    {
        $this->getResponse()->display($this::pageTemplate, []);
    }
}