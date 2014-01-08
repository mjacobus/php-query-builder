<?php

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_SelectStatementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs_QueryBuilder_SelectStatement
     */
    protected $o;

    public function setUp()
    {
        $this->o = new Gs_QueryBuilder_SelectStatement(new Gs_QueryBuilder);
    }

    /**
     * @test
     */
    public function itSetQueryBuilderOnTheConstructor()
    {
        $this->assertInstanceOf('Gs_QueryBuilder_Statement', $this->o);
    }

    /**
     * @test
     */
    public function itConvertsCorrectlyToString()
    {
        $this->o->addParams(array('field1', 'field2'));

        $this->assertEquals('SELECT field1, field2', $this->o->toString());
    }

    /**
     * @test
     */
    public function itSelectsAllWhenNoParamIsGiven()
    {
        $this->assertEquals('SELECT *', $this->o->toString());
    }

}
