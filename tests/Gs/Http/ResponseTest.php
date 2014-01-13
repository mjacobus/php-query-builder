<?php
require_once 'Gs/Http/Response.php';

class Gs_Http_ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Gs_Http_Response
     */
    protected $o;

    public function setUp()
    {
        $this->o = new Gs_Http_Response;
    }


    /**
     * @test
     */
    public function itCanAppendContentToBody()
    {
        $body = $this->o->append('ha')->append('he')->getBody();
        $this->assertEquals('hahe', $this->o->getBody());
    }

    /**
     * @test
     */
    public function itCanSetBody()
    {
        $body= $this->o->setBody('body')->setBody('new body');
        $this->assertEquals('new body', $this->o->getBody());
    }

}
