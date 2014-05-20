<?php

namespace POTests\QueryBuilder;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\GroupStatement;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class GroupStatementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param PO\QueryBuilder\GroupStatement
     */
    protected $o;

    public function setUp()
    {
        $this->o = new GroupStatement(new QueryBuilder);
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
        $this->assertEquals('GROUP BY foo', $this->o->toSql());

        $this->o->addParam('bar');
        $this->assertEquals('GROUP BY foo, bar', $this->o->toSql());
    }

    /**
     * @test
     */
    public function itReturnsEmptyStringWhenNoParamIsGiven()
    {
        $this->assertEquals('', $this->o->toSql());
    }
}
