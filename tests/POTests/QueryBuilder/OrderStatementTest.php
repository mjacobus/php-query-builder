<?php

/**
 * @see Gs_QueryBuilder_OrderStatement
 */
require_once 'Gs/QueryBuilder/OrderStatement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_OrderStatementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs_QueryBuilder_OrderStatement
     */
    protected $o;

    public function setUp()
    {
        $this->o = new Gs_QueryBuilder_OrderStatement(new Gs_QueryBuilder);
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
        $this->o->addParam('foo');
        $this->assertEquals('ORDER BY foo', $this->o->toSql());

        $this->o->addParam('bar DESC');
        $this->assertEquals('ORDER BY foo, bar DESC', $this->o->toSql());
    }

    /**
     * @test
     */
    public function itReturnsEmptyStringWhenNoParamIsGiven()
    {
        $this->assertEquals('', $this->o->toSql());
    }

}
