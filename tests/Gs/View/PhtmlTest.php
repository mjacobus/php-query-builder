<?php

require_once 'Gs/View/Phtml.php';

class Gs_View_PhtmlTest extends PHPUnit_Framework_Testcase
{
    /**
     * @var Gs_View_Phtml
     */
    protected $o;
    protected $variables = array('name' => 'Foo', 'greeting' => 'Hello');


    public function setUp()
    {
        $variables      = $this->variables;
        $template       = FIXTURES_PATH . 'template.phtml';
        $this->template = $template;

        $this->o = new Gs_View_Phtml(array(
            'template' => $template,
            'variables' => $variables
        ));
    }

    /**
     * @test
     */
    public function itCanSetVariables()
    {
        $this->assertEquals($this->variables, $this->o->getVariables());
    }

    /**
     * @test
     */
    public function itDefaultsVariablesToEmptyArray()
    {
        $object = new Gs_View_Phtml(array('template' => 'some_file'));

        $this->assertEquals(array(), $object->getVariables());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function itRequiresTemplateFile()
    {
        new Gs_View_Phtml(array());
    }

    /**
     * @test
     */
    public function itCanRenderTemplate()
    {
        $this->assertContains('Hello Foo', $this->o->render());
    }

    /**
     * @test
     */
    public function itBindTheViewObjectToTheTemplate()
    {
        $this->assertContains($this->o->getTemplate(), $this->o->render());
    }
}
