<?php

namespace POTests\QueryBuilder;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\Statement;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class StatementTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param PO\QueryBuilder\Statement $query
     */
    protected $o;

    public function setUp()
    {
        $this->o = new Statement(new QueryBuilder);
    }

    /**
     * @test
     */
    public function itSetQueryBuilderOnTheConstructor()
    {
        $this->assertInstanceOf('PO\QueryBuilder', $this->o->getBuilder());
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
