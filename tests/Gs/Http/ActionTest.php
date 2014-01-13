<?php

require_once 'Gs/Http/Action.php';

class Gs_Http_ActionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Gs_Http_Action
     */
    protected $o;

    /**
     * @var Gs_Http_Request
     */
    protected $request;

    /**
     * @var Gs_Http_Response
     */
    protected $response;

    protected $sever = array('server' => 'varable');

    public function setUp()
    {
        $this->request = new Gs_Http_Request;
        $this->response = new Gs_Http_Response;
        $this->o = new Gs_Http_Action($this->request, $this->response);
    }

    /**
     * @test
     */
    public function itCanExecuteAction()
    {
        $this->o->execute();
    }

    /**
     * @test
     */
    public function itCanSetRequest()
    {
        $this->assertSame($this->request, $this->o->getRequest());
    }

}

