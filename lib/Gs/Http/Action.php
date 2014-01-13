<?php

/**
 * @var Gs_Http_Request
 */
require_once 'Gs/Http/Request.php';

/**
 * @var Gs_Http_Response
 */
require_once 'Gs/Http/Response.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_Http_Action
{


    /**
     * @var Gs_Http_Request
     */
    protected $_request;

    /**
     * @var Gs_Http_Response
     */
    protected $_response;

    /**
     * Run action. Must Be overwitten
     */
    public function execute()
    {

    }


    /**
     * Here is where the actionshould be executed
     * @param Gs_Http_Request $request
     * @param Gs_Http_Response $response
     */
    public function __construct(Gs_Http_Request $request, Gs_Http_Response $response)
    {
        $this->_request  = $request;
        $this->_response = $response;
    }

    /**
     * Get the request
     * @return Gs_Http_Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Get the request
     * @return Gs_Http_Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

}

