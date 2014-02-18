<?php

/**
 * @see Gs_QueryBuilder_LimitStatement
 */
require_once 'Gs/QueryBuilder/LimitStatement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_LimitStatementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs_QueryBuilder_LimitStatement
     */
    protected $o;

    public function setUp()
    {
        $this->o = new Gs_QueryBuilder_LimitStatement(new Gs_QueryBuilder);
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
        $this->o->addParam(1);
        $this->assertEquals('LIMIT 1', $this->o->toSql());

        $this->o->addParam('2');
        $this->assertEquals('LIMIT 1, 2', $this->o->toSql());
    }

    /**
     * @test
     */
    public function itReturnsEmptyStringWhenNoParamIsGiven()
    {
        $this->assertEquals('', $this->o->toSql());
    }

}
