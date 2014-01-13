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

    protected $sever = array('server' => 'varable');

    public function setUp()
    {
        $this->request = new Gs_Http_Request;
        $this->o = new Gs_Http_Action;
    }

    /**
     * @test
     */
    public function itCanExecuteAction()
    {
        $this->o->execute($this->request);
    }

}

