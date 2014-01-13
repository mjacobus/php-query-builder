<?php

require_once 'Gs/Params.php';


/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_ParamsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Gs_Params
     */
    protected $o;


    public function setUp()
    {
        $this->o = new Gs_Params(array(
            'a' => 'Argentina',
            'b' => 'Brazil',
        ));
    }

    /**
     * @test
     */
    public function itCanGetAll()
    {
        $expectedParams = array(
            'a' => 'Argentina',
            'b' => 'Brazil',
        );

        $this->assertEquals($expectedParams, $this->o->getAll());
        $this->assertEquals($expectedParams, $this->o->get());
    }

    /**
     * @test
     */
    public function itCanGetParam()
    {
        $this->assertEquals('Argentina', $this->o->get('a'));
        $this->assertEquals('Brazil', $this->o->get('b'));
        $this->assertNull($this->o->get('c'));
        $this->assertEquals('default', $this->o->get('c', 'default'));
    }

    /**
     * @test
     */
    public function itCanCheckIfValueIsSet()
    {
        $this->assertTrue($this->o->keyExists('a'));
        $this->assertFalse($this->o->keyExists('c'));
        $this->assertTrue($this->o->offsetExists('a'));
        $this->assertFalse($this->o->offsetExists('c'));
    }

    /**
     * @test
     */
    public function itCanIterateObject()
    {
        $values = array();

        foreach($this->o as $value) {
            $values[] = $value;
        }

        $this->assertEquals(array('Argentina', 'Brazil'), $values);

        $values = array();

        foreach($this->o as $key => $value) {
            $values[$key] = $value;
        }

        $this->assertEquals($this->o->getAll(), $values);
    }

    /**
     * @test
     */
    public function itCanBeAccessedAsArray()
    {
        $this->assertEquals('Argentina', $this->o['a']);
        $this->assertNull($this->o['c']);
    }

    /**
     * @test
     */
    public function itCanSetValueAsArray()
    {
        $this->o['c'] = 'Cuba';
        $this->assertEquals('Cuba', $this->o['c']);
    }

    /**
     * @test
     **/
    public function canUnsetValue()
    {
        $this->o->offsetUnset('a');
        $this->assertEquals(array('b' => 'Brazil'), $this->o->getAll());
    }

}

