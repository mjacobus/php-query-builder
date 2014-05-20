<?php

namespace POTests\QueryBuilder;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\LimitStatement;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class OrderStatementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param PO\QueryBuilder\OrderStatement
     */
    protected $o;

    public function setUp()
    {
        $this->o = new OrderStatement(new QueryBuilder);
    }

    /**
     * @test
     */
    public function itSetQueryBuilderOnTheConstructor()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Statement', $this->o);
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
