<?php

require_once 'Gs/ClassLoader.php';

class Gs_ClassLoaderTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Gs_ClassLoader
     */
    protected $o;

    public function setUp()
    {
        $this->o = new Gs_ClassLoader;
    }

    /**
     * @test
     */
    public function itCanResolveFileName()
    {
        $class = 'Some_VeryNice_Class';
        $filePath = 'Some/VeryNice/Class.php';
        $this->assertEquals($filePath, $this->o->fileName($class));
    }
}
