<?php

namespace POTests\QueryBuilder;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\LimitClause;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class LimitClauseTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param PO\QueryBuilder\LimitClause
     */
    protected $o;

    public function setUp()
    {
        $this->o = new LimitClause(new QueryBuilder);
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
