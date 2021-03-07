<?php

namespace AC\Controllers\Page;

use AC\Controllers\BaseController;
use AC\Service\Http\Request;
use AC\Service\Http\Response;

class IndexController //extends BaseController
{
//    /**
//     * @var Response
//     */
//    private $response;
//
//    /**
//     * @var Request
//     */
//    private $request;

////    /**
////     * @param Response $response
////     * @param Request $request
////     */
//    function __construct()
//    {
////        $this->response = $response;
////        $this->request = $request;
////        parent::__construct($response, $request);
//    }

    public const KEK = 'kek';

    public function render()
    {
        echo 'EBANA';
    }
}