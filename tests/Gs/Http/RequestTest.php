<?php

require_once 'Gs/Http/Request.php';

class Gs_Http_RequestTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs/Request
     */
    protected $o;
    protected $server = array('foo_server' => 'bar');
    protected $post   = array('foo_post' => 'bar');
    protected $get    = array('foo_get' => 'bar');

    public function setUp()
    {
        $this->o = new Gs_Http_Request($this->server, $this->post, $this->get);
    }

    /**
     * @test
     */
    public function itCanGetTheServerVars()
    {
        $this->assertEquals($this->server, $this->o->getServer());
        $this->assertEquals('bar', $this->o->getServer('foo_server'));
        $this->assertNull($this->o->getServer('undefined'));
        $this->assertEquals('bar', $this->o->getServer('undefined', 'bar'));
    }

    /**
     * @test
     */
    public function itCanGetThePostVars()
    {
        $this->assertEquals($this->post, $this->o->getPost());
        $this->assertEquals('bar', $this->o->getPost('foo_post'));
        $this->assertNull($this->o->getPost('undefined'));
        $this->assertEquals('bar', $this->o->getPost('undefined', 'bar'));
    }

    /**
     * @test
     */
    public function itCanGetTheGetVars()
    {
        $this->assertEquals($this->get, $this->o->getGet());
        $this->assertEquals('bar', $this->o->getGet('foo_get'));
        $this->assertNull($this->o->getGet('undefined'));
        $this->assertEquals('bar', $this->o->getGet('undefined', 'bar'));
    }

    /**
     * @test
     */
    public function itCanGetParams()
    {
        $this->o = new Gs_Http_Request(array(), array('a' => 'a'), array('a' => 'b', 'c' => 'c'));
        $this->assertEquals('a', $this->o->getParam('a'));
        $this->assertEquals('c', $this->o->getParam('c'));
        $this->assertEquals('x', $this->o->getParam('y', 'x'));
    }

    /**
     * @test
     */
    public function itCanGetAllParams()
    {
        $this->o = new Gs_Http_Request(array(), array('a' => 'a'), array('a' => 'b', 'c' => 'c'));

        $expectedParams = array(
            'a' => 'a',
            'c' => 'c'
        );

        $this->assertEquals($expectedParams, $this->o->getParams());
    }

    /**
     * @test
     */
    public function itCanGetRequestMethod()
    {
        $this->o = new Gs_Http_Request(array('REQUEST_METHOD' => 'GET'));
        $this->assertEquals('GET', $this->o->getMethod());
    }

    /**
     * @test
     */
    public function itCanCheckIfRequestIsPost()
    {
        $this->o = new Gs_Http_Request(array('REQUEST_METHOD' => 'POST'));
        $this->assertTrue($this->o->isPost());

        $this->o = new Gs_Http_Request(array('REQUEST_METHOD' => 'GET'));
        $this->assertFalse($this->o->isPost());
    }

    /**
     * @test
     */
    public function itCanCheckIfRequestIsAjax()
    {
        $this->o = new Gs_Http_Request(array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'));
        $this->assertTrue($this->o->isAjax());

        $this->o = new Gs_Http_Request();
        $this->assertFalse($this->o->isAjax());
    }

}
