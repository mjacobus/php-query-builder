<?php

/**
 * @see Gs_QueryBuilder_Statement
 */
require_once 'Gs/QueryBuilder/Statement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_StatementTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param Gs_QueryBuilder_Statement $query
     */
    protected $o;

    public function setUp()
    {
        $this->o = new Gs_QueryBuilder_Statement(new Gs_QueryBuilder);
    }

    /**
     * @test
     */
    public function itSetQueryBuilderOnTheConstructor()
    {
        $this->assertInstanceOf('Gs_QueryBuilder', $this->o->getBuilder());
    }

    /**
     * @test
     */
    public function itCanAddParamsOneByOne()
    {
        $this->o->addParam('one')->addParam('two');
        $this->assertEquals(array('one', 'two'), $this->o->getParams());
    }

    /**
     * @test
     */
    public function itCanAddCollectionOfParams()
    {
        $this->o->addParam('one')->addParams(array('two', 'three'));
        $this->assertEquals(array('one', 'two', 'three'), $this->o->getParams());
    }

    /**
     * @test
     */
    public function itCanSetParams()
    {
        $this->o->addParam('one')->setParams(array('two', 'three'));
        $this->assertEquals(array('two', 'three'), $this->o->getParams());
    }

    /**
     * @test
     */
    public function itCanResetParams()
    {
        $this->o->addParam('one')->addParam('two')->reset();
        $this->assertEquals(array(), $this->o->getParams());
    }

    /**
     * @test
     */
    public function itsStringVersionIsEmpty()
    {
        $this->assertEquals('', $this->o);
    }
}
