<?php

/**
 * @see Gs_QueryBuilder_FromStatement
 */
require_once 'Gs/QueryBuilder/FromStatement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_FromStatementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs_QueryBuilder_FromStatement
     */
    protected $o;

    public function setUp()
    {
        $this->o = new Gs_QueryBuilder_FromStatement(new Gs_QueryBuilder);
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
        $this->o->addParams(array('table t1', 'INNER JOIN table2 t2 ON t1.id = t2.t1_id'));

        $this->assertEquals(
            'FROM table t1 INNER JOIN table2 t2 ON t1.id = t2.t1_id',
            $this->o->toSql()
        );
    }

    /**
     * @test
     */
    public function itReturnsEmptyStringWhenNoParamIsGiven()
    {
        $this->assertEquals('', $this->o->toSql());
    }

    /**
     * @test
     */
    public function itInnerJoinsTable()
    {
        $this->o->addParam('t1');
        $this->o->innerJoin('t2');
        $this->assertEquals('FROM t1 INNER JOIN t2', $this->o->toSql());
    }

    /**
     * @test
     */
    public function itInnerJoinsTableWithOnCondition()
    {
        $this->o->addParam('t1');
        $this->o->leftJoin('t2', 't1.id = t2.t1_id');
        $this->assertEquals(
            'FROM t1 LEFT JOIN t2 ON t1.id = t2.t1_id',
            $this->o->toSql()
        );
    }

    /**
     * @test
     */
    public function itLeftJoinsTable()
    {
        $this->o->addParam('t1');
        $this->o->leftJoin('t2');
        $this->assertEquals('FROM t1 LEFT JOIN t2', $this->o->toSql());
    }

    /**
     * @test
     */
    public function itLeftJoinsTableWithOnCondition()
    {
        $this->o->addParam('t1');
        $this->o->innerJoin('t2', 't1.id = t2.t1_id');
        $this->assertEquals(
            'FROM t1 INNER JOIN t2 ON t1.id = t2.t1_id',
            $this->o->toSql()
        );
    }


}
