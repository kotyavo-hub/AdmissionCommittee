<?php

namespace AC\Controllers\Page;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class IndexPageController extends BasePageController
{
    protected const pageTemplate = 'indexTemplate.twig';

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render()
    {
        $this->display($this::pageTemplate, []);
    }
}